<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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

        foreach ($rules as $rule) {
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

        $result = AssessmentResult::create([
            'user_id'       => Auth::id(),
            'total_score'   => $totalScore,
            'group_scores'  => $groupScores,
            'matched_rules' => collect($matchedRules)->pluck('id')->toArray(),
            'notes'         => null,
        ]);

        foreach ($selections as $groupId => $subGroups) {
            foreach ($subGroups as $subGroupId => $selection) {
                AssessmentResultOption::create([
                    'assessment_result_id'   => $result->id,
                    'assessment_option_id'   => $selection['option_id'],
                    'assessment_group_id'    => $groupId,
                    'assessment_sub_group_id' => $subGroupId,
                ]);
            }
        }

        session()->forget('assessment_selections');

        return view('assessments.review', compact(
            'groups', 'selections', 'groupScores', 'totalScore', 'matchedRules', 'result'
        ));
    }

    public function history()
    {
        $results = AssessmentResult::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('assessments.history', compact('results'));
    }

    public function detail($id)
    {
        $result = AssessmentResult::where('user_id', Auth::id())
            ->with(['resultOptions.option.subGroup.group', 'resultOptions.group', 'resultOptions.subGroup'])
            ->findOrFail($id);

        $groups = AssessmentGroup::with('subGroups')->orderBy('order')->get();

        $selections = [];
        foreach ($result->resultOptions as $ro) {
            $option = $ro->option;
            $selections[$ro->assessment_group_id][$ro->assessment_sub_group_id] = [
                'option_id'    => $option->id,
                'text'         => $option->text,
                'score'        => $option->score,
                'image'        => $option->image,
                'group_id'     => $ro->assessment_group_id,
                'sub_group_id' => $ro->assessment_sub_group_id,
            ];
        }

        $matchedRules = AssessmentRule::whereIn('id', $result->matched_rules ?? [])->get();

        return view('assessments.detail', compact('result', 'groups', 'selections', 'matchedRules'));
    }
}
