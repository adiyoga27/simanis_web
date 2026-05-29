<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AssessmentConclusion;
use App\Models\AssessmentGroup;
use App\Models\AssessmentOption;
use App\Models\AssessmentResult;
use App\Models\AssessmentResultOption;
use App\Models\AssessmentRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function index()
    {
        $groups = AssessmentGroup::orderBy('order')->get();

        return view('assessments.index', compact('groups'));
    }

    public function start()
    {
        session()->forget('assessment_selections');

        $firstGroup = AssessmentGroup::orderBy('order')->first();

        if (!$firstGroup) {
            return redirect()->route('assessment.index')->with('error', 'Belum ada kelompok penilaian.');
        }

        return redirect()->route('assessment.step', $firstGroup->slug);
    }

    public function step($groupSlug)
    {
        $group = AssessmentGroup::where('slug', $groupSlug)->with(['subGroups.options' => function ($q) {
            $q->orderBy('order');
        }])->firstOrFail();

        $groups = AssessmentGroup::orderBy('order')->get();
        $selections = session('assessment_selections', []);
        $currentIndex = $groups->search(fn($g) => $g->id === $group->id);
        $totalGroups = $groups->count();
        $isLast = $currentIndex === $totalGroups - 1;


        $nextGroup = $isLast ? null : $groups[$currentIndex + 1] ?? null;
        $prevGroup = $currentIndex > 0 ? $groups[$currentIndex - 1] : null;

        return view('assessments.step', compact(
            'group', 'groups', 'selections', 'currentIndex', 'totalGroups', 'isLast', 'nextGroup', 'prevGroup'
        ));
    }

    public function saveStep(Request $request, $groupSlug)
    {
        $group = AssessmentGroup::where('slug', $groupSlug)->with('subGroups')->firstOrFail();

        $rules = [];
        foreach ($group->subGroups as $subGroup) {
            $rules["options.{$subGroup->id}"] = 'required|exists:assessment_options,id';
        }

        $validated = $request->validate($rules, [
            'options.*.required' => 'Pilih salah satu opsi untuk setiap sub-kelompok.',
        ]);

        $selections = session('assessment_selections', []);

        foreach ($validated['options'] as $subGroupId => $optionId) {
            $option = AssessmentOption::with('subGroup')->find($optionId);
            $selections[$group->id][$subGroupId] = [
                'option_id'   => $optionId,
                'text'        => $option->text,
                'score'       => $option->score,
                'image'       => $option->image,
                'group_id'    => $group->id,
                'sub_group_id' => $subGroupId,
            ];
        }

        session(['assessment_selections' => $selections]);

        $groups = AssessmentGroup::orderBy('order')->get();
        $currentIndex = $groups->search(fn($g) => $g->id === $group->id);
        $nextGroup = $groups[$currentIndex + 1] ?? null;

        if ($nextGroup) {
            return redirect()->route('assessment.step', $nextGroup->slug);
        }

        return redirect()->route('assessment.review');
    }

    public function review()
    {
        $selections = session('assessment_selections', []);

        if (empty($selections)) {
            return redirect()->route('assessment.index')->with('error', 'Belum ada penilaian. Silakan mulai penilaian.');
        }

        $groups = AssessmentGroup::with('subGroups')->orderBy('order')->get();

        $groupScores = [];
        $totalScore = 0;

        foreach ($selections as $groupId => $subGroups) {
            $groupScore = 0;
            foreach ($subGroups as $selection) {
                $groupScore += $selection['score'];
            }
            $groupScores[$groupId] = $groupScore;
            $totalScore += $groupScore;
        }

        $rules = AssessmentRule::orderBy('order')->get();
        $matchedRules = [];
        $aggregateResults = []; // [rule_id => ['total' => x, 'group_names' => []]]

        foreach ($rules as $rule) {
            if ($rule->score_mode === 'aggregate') {
                $selectedGroups = $rule->selected_groups ?? [];
                if (is_string($selectedGroups)) {
                    $selectedGroups = json_decode($selectedGroups, true) ?? [];
                }
                if (empty($selectedGroups)) continue;

                $aggregateTotal = 0;
                $groupNames = [];
                foreach ($selectedGroups as $gId) {
                    $aggregateTotal += $groupScores[$gId] ?? 0;
                    $groupName = AssessmentGroup::find($gId)?->title;
                    if ($groupName) $groupNames[] = $groupName;
                }

                $minOk = $rule->min_score === null || $aggregateTotal >= $rule->min_score;
                $maxOk = $rule->max_score === null || $aggregateTotal <= $rule->max_score;

                if ($minOk && $maxOk) {
                    $matchedRules[] = $rule;
                    $aggregateResults[$rule->id] = [
                        'total'       => $aggregateTotal,
                        'group_names' => $groupNames,
                    ];
                }
            } else {
                $conditions = $rule->conditions;
                if (is_string($conditions)) {
                    $conditions = json_decode($conditions, true) ?? [];
                }
                $allMatch = true;

                foreach ($conditions as $condGroupId => $minScore) {
                    if (!isset($groupScores[$condGroupId]) || $groupScores[$condGroupId] < $minScore) {
                        $allMatch = false;
                        break;
                    }
                }

                if ($allMatch) {
                    $matchedRules[] = $rule;
                }
            }
        }

        $result = AssessmentResult::create([
            'user_id'       => $this->getDataEntryUserId(),
            'total_score'   => $totalScore,
            'group_scores'  => $groupScores,
            'matched_rules' => collect($matchedRules)->pluck('id')->toArray(),
            'conclusion_id' => $this->matchConclusion($groupScores),
            'notes'         => null,
        ]);

        foreach ($selections as $groupId => $subGroups) {
            foreach ($subGroups as $subGroupId => $selection) {
                AssessmentResultOption::create([
                    'assessment_result_id'   => $result->id,
                    'assessment_option_id'   => $selection['option_id'],
                    'assessment_group_id'    => $groupId,
                    'assessment_sub_group_id' => $subGroupId,
                    'option_text'            => $selection['text'],
                    'option_score'           => $selection['score'],
                    'option_image'           => $selection['image'],
                ]);
            }
        }

        session()->forget('assessment_selections');

        return redirect()->route('assessment.detail', $result->id);
    }

    private function matchConclusion(array $groupScores): ?int
    {
        $conclusions = AssessmentConclusion::with('conditions.category')->orderBy('priority')->get();

        if ($conclusions->isEmpty()) return null;

        $rules = AssessmentRule::with('category')->orderBy('order')->get();
        $matchedRuleIds = collect($this->matchAllRules($groupScores, $rules))->pluck('id')->toArray();

        foreach ($conclusions as $conclusion) {
            if ($conclusion->conditions->isEmpty()) continue;

            $result = null;

            foreach ($conclusion->conditions as $condition) {
                $category = $condition->category;
                if (!$category) continue;

                $categoryRuleIds = $category->rules->pluck('id')->toArray();
                $categoryMatchedRules = array_intersect($matchedRuleIds, $categoryRuleIds);

                if ($condition->target_severity) {
                    $severityMatched = 0;
                    foreach ($categoryMatchedRules as $ruleId) {
                        $rule = $rules->find($ruleId);
                        if ($rule && $rule->severity === $condition->target_severity) {
                            $severityMatched++;
                        }
                    }
                    $matchedCount = $severityMatched;
                } else {
                    $matchedCount = count($categoryMatchedRules);
                }

                $condResult = $matchedCount >= $condition->min_matched_rules;

                if ($result === null) {
                    $result = $condResult;
                } elseif ($condition->logic === 'or') {
                    $result = $result || $condResult;
                } else {
                    $result = $result && $condResult;
                }
            }

            if ($result) {
                return $conclusion->id;
            }
        }

        return null;
    }

    private function matchAllRules(array $groupScores, $rules): array
    {
        $matched = [];

        foreach ($rules as $rule) {
            if ($rule->score_mode === 'aggregate') {
                $selectedGroups = $rule->selected_groups ?? [];
                if (is_string($selectedGroups)) {
                    $selectedGroups = json_decode($selectedGroups, true) ?? [];
                }
                if (empty($selectedGroups)) continue;

                $aggregateTotal = 0;
                foreach ($selectedGroups as $gId) {
                    $aggregateTotal += $groupScores[$gId] ?? 0;
                }

                $minOk = $rule->min_score === null || $aggregateTotal >= $rule->min_score;
                $maxOk = $rule->max_score === null || $aggregateTotal <= $rule->max_score;

                if ($minOk && $maxOk) {
                    $matched[] = $rule;
                }
            } else {
                $conditions = $rule->conditions;
                if (is_string($conditions)) {
                    $conditions = json_decode($conditions, true) ?? [];
                }
                $allMatch = true;

                foreach ($conditions as $condGroupId => $minScore) {
                    if (!isset($groupScores[$condGroupId]) || $groupScores[$condGroupId] < $minScore) {
                        $allMatch = false;
                        break;
                    }
                }

                if ($allMatch) {
                    $matched[] = $rule;
                }
            }
        }

        return $matched;
    }

    public function history()
    {
        $results = AssessmentResult::where('user_id', $this->getDataEntryUserId())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('assessments.history', compact('results'));
    }

    public function detail($id)
    {
        $result = AssessmentResult::where('user_id', $this->getDataEntryUserId())
            ->with(['resultOptions.option', 'conclusion'])
            ->findOrFail($id);

        $groups = AssessmentGroup::with('subGroups')->orderBy('order')->get();

        $selections = [];
        foreach ($result->resultOptions as $ro) {
            $selections[$ro->assessment_group_id][$ro->assessment_sub_group_id] = [
                'option_id'    => $ro->assessment_option_id,
                'text'         => $ro->option_text ?? $ro->option?->text ?? '',
                'score'        => $ro->option_score ?? $ro->option?->score ?? 0,
                'image'        => $ro->option_image ?? $ro->option?->image ?? null,
                'group_id'     => $ro->assessment_group_id,
                'sub_group_id' => $ro->assessment_sub_group_id,
            ];
        }

        $matchedRules = AssessmentRule::whereIn('id', $result->matched_rules ?? [])->get();

        $groupScores = $result->group_scores ?? [];
        $aggregateResults = [];
        foreach ($matchedRules as $rule) {
            if ($rule->score_mode === 'aggregate') {
                $selectedGroups = $rule->selected_groups ?? [];
                if (is_string($selectedGroups)) {
                    $selectedGroups = json_decode($selectedGroups, true) ?? [];
                }
                $aggregateTotal = 0;
                $groupNames = [];
                foreach ($selectedGroups as $gId) {
                    $aggregateTotal += $groupScores[$gId] ?? 0;
                    $name = AssessmentGroup::find($gId)?->title;
                    if ($name) $groupNames[] = $name;
                }
                $aggregateResults[$rule->id] = [
                    'total'       => $aggregateTotal,
                    'group_names' => $groupNames,
                ];
            }
        }

        return view('assessments.detail', compact('result', 'groups', 'selections', 'matchedRules', 'aggregateResults'));
    }
}
