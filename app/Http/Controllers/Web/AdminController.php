<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AssessmentGroup;
use App\Models\AssessmentResult;
use App\Models\AssessmentRule;
use App\Models\BloodSugarRecord;
use App\Models\Education;
use App\Models\FootScreeningResult;
use App\Models\Medication;
use App\Models\TntCalculation;
use App\Models\User;
use App\Models\WeightLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalEducations = Education::count();
        $totalBloodSugar = BloodSugarRecord::count();
        $totalFootScreenings = FootScreeningResult::count();
        $totalTnt = TntCalculation::count();
        $totalMedications = Medication::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalEducations',
            'totalBloodSugar',
            'totalFootScreenings',
            'totalTnt',
            'totalMedications'
        ));
    }

    public function users(Request $request)
    {
        $query = User::query();

        $search = $request->get('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }

    public function userDetail($id)
    {
        $user = User::findOrFail($id);

        $bloodSugarCount = BloodSugarRecord::where('user_id', $user->id)->count();
        $footScreeningCount = FootScreeningResult::where('user_id', $user->id)->count();
        $tntCount = TntCalculation::where('user_id', $user->id)->count();
        $medicationCount = Medication::where('user_id', $user->id)->count();
        $weightLogCount = WeightLog::where('user_id', $user->id)->count();

        $recentBloodSugar = BloodSugarRecord::where('user_id', $user->id)
            ->orderBy('recorded_at', 'desc')
            ->limit(5)
            ->get();

        $recentFootScreening = FootScreeningResult::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $assessmentCount = AssessmentResult::where('user_id', $user->id)->count();
        $recentAssessments = AssessmentResult::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.users.detail', compact(
            'user',
            'bloodSugarCount',
            'footScreeningCount',
            'tntCount',
            'medicationCount',
            'weightLogCount',
            'recentBloodSugar',
            'recentFootScreening',
            'assessmentCount',
            'recentAssessments'
        ));
    }

    public function userEdit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'role' => 'required|in:admin,user',
            'email_verified_at' => 'nullable|in:0,1',
        ]);

        $user->role = $validated['role'];

        if ($request->has('email_verified_at')) {
            $user->email_verified_at = $validated['email_verified_at'] == '1' ? ($user->email_verified_at ?? now()) : null;
        }

        $user->save();

        return redirect()->route('admin.users.detail', $user->id)->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function userAssessmentDetail($userId, $resultId)
    {
        $user = User::findOrFail($userId);
        $result = AssessmentResult::where('user_id', $user->id)
            ->with(['resultOptions.option'])
            ->findOrFail($resultId);

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

    // ─── MONITORING ────────────────────────────────────────────────────

    public function monitoringFootScreening(Request $request)
    {
        $search = $request->get('search');

        $results = FootScreeningResult::with('user')
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.monitoring.foot-screening', compact('results', 'search'));
    }

    public function monitoringFootScreeningDetail($id)
    {
        $result = FootScreeningResult::with('user')->findOrFail($id);

        return view('admin.monitoring.foot-screening-detail', compact('result'));
    }

    public function monitoringAssessments(Request $request)
    {
        $search = $request->get('search');

        $results = AssessmentResult::with('user')
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.monitoring.assessments', compact('results', 'search'));
    }
}
