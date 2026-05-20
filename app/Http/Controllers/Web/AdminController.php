<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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

        return view('admin.users.detail', compact(
            'user',
            'bloodSugarCount',
            'footScreeningCount',
            'tntCount',
            'medicationCount',
            'weightLogCount',
            'recentBloodSugar',
            'recentFootScreening'
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
}
