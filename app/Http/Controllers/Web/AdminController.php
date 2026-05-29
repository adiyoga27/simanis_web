<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AssessmentGroup;
use App\Models\AssessmentResult;
use App\Models\AssessmentRule;
use App\Models\BloodSugarRecord;
use App\Models\Desa;
use App\Models\Education;
use App\Models\EducationCategory;
use App\Models\FootScreeningResult;
use App\Models\Medication;
use App\Models\TntCalculation;
use App\Models\User;
use App\Models\WeightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalPatients = User::where('role', 'pasien')->count();
        $totalDesas = Desa::count();
        $totalEducations = Education::count();
        $totalBloodSugar = BloodSugarRecord::count();
        $totalFootScreenings = FootScreeningResult::count();
        $totalTnt = TntCalculation::count();
        $totalMedications = Medication::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPatients',
            'totalDesas',
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

        $role = $request->get('role');
        if ($role) {
            $query->where('role', $role);
        }
        $query->where('role', '!=', 'pasien');

        $desaId = $request->get('desa_id');
        if ($desaId) {
            $query->where('desa_id', $desaId);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $desas = Desa::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'search', 'desas', 'role', 'desaId'));
    }

    public function createUser()
    {
        $desas = Desa::orderBy('name')->get();
        $currentUser = Auth::user();

        $availableRoles = [];
        if ($currentUser->role === 'superadmin') {
            $availableRoles = ['kepala_puskesmas' => 'Kepala Puskesmas', 'kepala_desa' => 'Kepala Desa', 'kader' => 'Kader'];
        } elseif ($currentUser->role === 'kepala_puskesmas') {
            $availableRoles = ['kepala_desa' => 'Kepala Desa', 'kader' => 'Kader'];
        } elseif ($currentUser->role === 'kepala_desa') {
            $availableRoles = ['kader' => 'Kader'];
        }

        return view('admin.users.create', compact('desas', 'availableRoles'));
    }

    public function storeUser(Request $request)
    {
        $currentUser = Auth::user();

        $allowedRoles = [];
        if ($currentUser->role === 'superadmin') {
            $allowedRoles = ['kepala_puskesmas', 'kepala_desa', 'kader'];
        } elseif ($currentUser->role === 'kepala_puskesmas') {
            $allowedRoles = ['kepala_desa', 'kader'];
        } elseif ($currentUser->role === 'kepala_desa') {
            $allowedRoles = ['kader'];
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:' . implode(',', $allowedRoles),
            'phone' => 'nullable|string|max:20',
            'jk' => 'required|in:L,P',
        ];

        if (in_array('kepala_desa', $allowedRoles) || in_array('kader', $allowedRoles)) {
            $rules['desa_id'] = 'nullable|exists:desas,id';
        }

        if ($currentUser->role === 'kepala_desa') {
            $request->merge(['desa_id' => $currentUser->desa_id]);
        }

        $validated = $request->validate($rules);

        if ($currentUser->role === 'kepala_desa' && $validated['role'] === 'kader') {
            $validated['desa_id'] = $currentUser->desa_id;
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();
        $validated['birthdate'] = $request->birthdate ?? '2000-01-01';
        $validated['is_smoke'] = $request->has('is_smoke');
        $validated['medical_history'] = $request->medical_history ?? '-';
        $validated['province'] = $request->province ?? 'Jawa Timur';
        $validated['city'] = $request->city ?? '';
        $validated['subdistrict'] = $request->subdistrict ?? '';
        $validated['village'] = $request->village ?? '';
        $validated['address'] = $request->address ?? '';
        $validated['kode_pos'] = $request->kode_pos ?? 0;
        $validated['tall'] = $request->tall ?? 0;
        $validated['weight'] = $request->weight ?? 0;
        $validated['blood'] = $request->blood ?? '';

        User::create($validated);

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil ditambahkan.');
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
            'role' => 'required|in:superadmin,kepala_puskesmas,kepala_desa,kader,pasien',
            'desa_id' => 'nullable|exists:desas,id',
        ]);

        $user->role = $validated['role'];

        if (in_array($validated['role'], ['kepala_desa', 'kader'])) {
            $user->desa_id = $validated['desa_id'] ?? null;
        }

        $user->email_verified_at = $user->email_verified_at ?? now();

        $user->save();

        return redirect()->route('admin.users.detail', $user->id)->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function userAssessmentDetail($userId, $resultId)
    {
        $user = User::findOrFail($userId);
        $result = AssessmentResult::where('user_id', $user->id)
            ->with(['resultOptions.option', 'conclusion'])
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
        $currentUser = Auth::user();
        $search = $request->get('search');
        $desaId = $request->get('desa_id');

        $results = FootScreeningResult::with('user')
            ->when(in_array($currentUser->role, ['kader', 'kepala_desa']) && $currentUser->desa_id, function ($q) use ($currentUser) {
                $q->whereHas('user', fn($u) => $u->where('desa_id', $currentUser->desa_id));
            })
            ->when($desaId && in_array($currentUser->role, ['superadmin', 'kepala_puskesmas']), function ($q) use ($desaId) {
                $q->whereHas('user', fn($u) => $u->where('desa_id', $desaId));
            })
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $desas = Desa::orderBy('name')->get();

        return view('admin.monitoring.foot-screening', compact('results', 'search', 'desas', 'desaId'));
    }

    public function monitoringFootScreeningDetail($id)
    {
        $result = FootScreeningResult::with('user')->findOrFail($id);

        return view('admin.monitoring.foot-screening-detail', compact('result'));
    }

    public function monitoringFootScreeningDestroy($id)
    {
        if (Auth::user()->role === 'kepala_puskesmas') {
            abort(403, 'Anda tidak memiliki izin untuk menghapus data.');
        }
        FootScreeningResult::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function monitoringAssessments(Request $request)
    {
        $currentUser = Auth::user();
        $search = $request->get('search');
        $desaId = $request->get('desa_id');

        $results = AssessmentResult::with('user')
            ->when(in_array($currentUser->role, ['kader', 'kepala_desa']) && $currentUser->desa_id, function ($q) use ($currentUser) {
                $q->whereHas('user', fn($u) => $u->where('desa_id', $currentUser->desa_id));
            })
            ->when($desaId && in_array($currentUser->role, ['superadmin', 'kepala_puskesmas']), function ($q) use ($desaId) {
                $q->whereHas('user', fn($u) => $u->where('desa_id', $desaId));
            })
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $desas = Desa::orderBy('name')->get();

        return view('admin.monitoring.assessments', compact('results', 'search', 'desas', 'desaId'));
    }

    public function monitoringAssessmentDestroy($id)
    {
        if (Auth::user()->role === 'kepala_puskesmas') {
            abort(403, 'Anda tidak memiliki izin untuk menghapus data.');
        }
        AssessmentResult::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function monitoringBloodSugar(Request $request)
    {
        $currentUser = Auth::user();
        $search = $request->get('search');
        $desaId = $request->get('desa_id');

        $baseQuery = BloodSugarRecord::query();
        if (in_array($currentUser->role, ['kader', 'kepala_desa']) && $currentUser->desa_id) {
            $baseQuery->whereHas('user', fn($u) => $u->where('desa_id', $currentUser->desa_id));
        }
        if ($desaId && in_array($currentUser->role, ['superadmin', 'kepala_puskesmas'])) {
            $baseQuery->whereHas('user', fn($u) => $u->where('desa_id', $desaId));
        }

        $statsQuery = clone $baseQuery;
        $stats = [];
        foreach (['Normal', 'Tinggi', 'Rendah', 'Sangat Tinggi', 'Sangat Rendah'] as $cat) {
            $stats[$cat] = (clone $statsQuery)->where('category', $cat)->count();
        }

        $results = $baseQuery->with('user')
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"));
            })
            ->orderBy('recorded_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $desas = Desa::orderBy('name')->get();

        return view('admin.monitoring.blood-sugar', compact('results', 'search', 'desas', 'desaId', 'stats'));
    }

    public function monitoringBloodSugarDestroy($id)
    {
        if (Auth::user()->role === 'kepala_puskesmas') {
            abort(403, 'Anda tidak memiliki izin untuk menghapus data.');
        }
        BloodSugarRecord::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function monitoringEducation()
    {
        $categories = EducationCategory::withCount('educations')->orderBy('created_at', 'desc')->get();

        return view('admin.monitoring.education', compact('categories'));
    }

    public function monitoringEducationArticles($categorySlug)
    {
        $category = EducationCategory::where('slug', $categorySlug)->firstOrFail();
        $educations = $category->educations()->orderBy('created_at', 'desc')->get();
        $categories = EducationCategory::withCount('educations')->orderBy('created_at', 'desc')->get();

        return view('admin.monitoring.education-articles', compact('category', 'educations', 'categories'));
    }

    public function monitoringEducationDetail($categorySlug, $articleSlug)
    {
        $category = EducationCategory::where('slug', $categorySlug)->firstOrFail();
        $education = Education::where('education_category_id', $category->id)->where('slug', $articleSlug)->firstOrFail();
        $categories = EducationCategory::withCount('educations')->orderBy('created_at', 'desc')->get();

        return view('admin.monitoring.education-detail', compact('category', 'education', 'categories'));
    }

    public function showSelectPatient(Request $request)
    {
        $currentUser = Auth::user();
        $redirectTo = $request->get('redirect_to', route('admin.dashboard'));
        $backUrl = $request->get('back', url()->previous());
        $q = $request->get('q');
        $filterDesaId = $request->get('desa_id');

        $pasienUsers = User::where('role', 'pasien')
            ->when(in_array($currentUser->role, ['kader', 'kepala_desa']) && $currentUser->desa_id, function ($query) use ($currentUser) {
                $query->where('desa_id', $currentUser->desa_id);
            })
            ->when($filterDesaId && in_array($currentUser->role, ['superadmin', 'kepala_puskesmas']), function ($query) use ($filterDesaId) {
                $query->where('desa_id', $filterDesaId);
            })
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->with('desa')
            ->orderBy('name')
            ->get();

        $desas = Desa::orderBy('name')->get();

        return view('admin.data-entry.select', compact('pasienUsers', 'redirectTo', 'backUrl', 'q', 'desas', 'filterDesaId'));
    }

    public function selectDataEntryUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'redirect_to' => 'required|string',
        ]);

        $user = User::where('role', 'pasien')->findOrFail($request->user_id);

        session([
            'admin_data_entry_user_id' => $user->id,
            'admin_data_entry_user_name' => $user->name,
        ]);

        return redirect()->to($request->redirect_to);
    }

    public function clearDataEntrySession(Request $request)
    {
        session()->forget(['admin_data_entry_user_id', 'admin_data_entry_user_name', 'assessment_selections']);

        $back = $request->get('back', route('admin.dashboard'));

        return redirect()->to($back);
    }
}
