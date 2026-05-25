<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BloodSugarRecord;
use App\Models\Diet;
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
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    public function landing()
    {
        return view('pages.landing');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $us = User::where('username', $credentials['username'])->whereNull('email_verified_at')->first();
        if ($us) {
            return back()->withErrors(['username' => 'Email belum diverifikasi. Silakan cek email Anda.']);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['username' => 'Username atau password salah.'])->onlyInput('username');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function doRegister(Request $request)
    {
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser && !$existingUser->hasVerifiedEmail()) {
            return redirect()->back()
                ->with('unverified_email', $request->email)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $payload = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'birthdate' => 'required|date',
            'phone' => 'nullable|string|max:20',
            'jk' => 'required|in:L,P',
            'blood' => 'required|string|max:5',
            'tall' => 'required|integer|min:50|max:300',
            'weight' => 'required|integer|min:20|max:500',
            'is_smoke' => 'required|integer|in:0,1',
            'medical_history' => 'nullable|string',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'subdistrict' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'address' => 'required|string',
            'kode_pos' => 'required|string|max:10',
        ]);

        $payload['password'] = Hash::make($payload['password']);
        $payload['role'] = 'pasien';
        $payload['birthdate'] = date('Y-m-d', strtotime($payload['birthdate']));
        $payload['medical_history'] = $payload['medical_history'] ?? '';

        $user = User::create($payload);
        $user->sendEmailVerificationNotification();

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi.');
    }

    public function resendVerificationWeb(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('success', 'Email sudah terverifikasi. Silakan login.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Link verifikasi telah dikirim ulang. Silakan cek inbox atau spam Anda.');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function newPassword()
    {
        return view('auth.new-password');
    }

    public function home()
    {
        $user = Auth::user();

        $educationCount = Education::count();
        $footScreeningCount = FootScreeningResult::where('user_id', $this->getDataEntryUserId())->count();
        $bloodSugarCount = BloodSugarRecord::where('user_id', $this->getDataEntryUserId())->count();
        $weightLogCount = WeightLog::where('user_id', $this->getDataEntryUserId())->count();
        $medicationCount = Medication::where('user_id', $this->getDataEntryUserId())->count();

        $recentBloodSugar = BloodSugarRecord::where('user_id', $this->getDataEntryUserId())
            ->orderBy('recorded_at', 'desc')
            ->limit(5)
            ->get();

        return view('home.dashboard', compact(
            'user',
            'educationCount',
            'footScreeningCount',
            'bloodSugarCount',
            'weightLogCount',
            'medicationCount',
            'recentBloodSugar'
        ));
    }

    public function education()
    {
        $categories = EducationCategory::whereIn('slug', ['edukasi', 'latihan-fisik', 'perawatan-kaki'])
            ->with('educations')
            ->get();

        $apiData = [];
        foreach (['edukasi', 'latihan-fisik', 'perawatan-kaki'] as $slug) {
            try {
                $res = Http::timeout(5)->get(url("/api/education/{$slug}"));
                if ($res->successful()) {
                    $apiData[$slug] = $res->json('data', []);
                }
            } catch (\Throwable $e) {
                $apiData[$slug] = [];
            }
        }

        return view('education.index', compact('categories', 'apiData'));
    }

    public function educationDetail($slug)
    {
        $category = EducationCategory::where('slug', $slug)->firstOrFail();
        $educations = $category->educations()->get();

        try {
            $res = Http::timeout(5)->get(url("/api/education/{$slug}"));
            $apiEducations = $res->successful() ? $res->json('data', []) : [];
        } catch (\Throwable $e) {
            $apiEducations = [];
        }

        return view('education.detail', compact('category', 'educations', 'apiEducations'));
    }

    public function educationShow($categorySlug, $articleSlug)
    {
        $category = EducationCategory::where('slug', $categorySlug)->firstOrFail();
        $education = Education::where('slug', $articleSlug)->firstOrFail();

        return view('education.show', compact('category', 'education'));
    }

    public function bloodSugar()
    {
        return view('blood-sugar.index');
    }

    public function bloodSugarGdp()
    {
        return view('blood-sugar.gdp');
    }

    public function bloodSugarGds()
    {
        return view('blood-sugar.gds');
    }

    public function bloodSugarTutorial()
    {
        return view('blood-sugar.tutorial');
    }

    public function footScreening()
    {
        return view('foot-screening.index');
    }

    public function footScreeningSurvey()
    {
        return view('foot-screening.survey');
    }

    public function footScreeningResult(Request $request)
    {
        $keys = ['sensasi_terbakar', 'sensasi_sentuhan', 'pulsasi_nyeri', 'pulsasi_kaki', 'pulsasi_pemeriksaan', 'bentuk_kulit', 'bentuk_kapalan', 'bentuk_kaki'];
        $answers = [];
        $score = 0;

        foreach ($keys as $key) {
            $value = $request->input($key, 'TIDAK');
            $answers[$key] = $value;
            if ($value === 'YA') {
                $score++;
            }
        }

        if ($score >= 3) {
            $riskLevel = 'Risiko Tinggi';
        } elseif ($score >= 1) {
            $riskLevel = 'Risiko Ringan';
        } else {
            $riskLevel = 'Normal';
        }

        FootScreeningResult::create([
            'user_id' => $this->getDataEntryUserId(),
            'score' => $score,
            'risk_level' => $riskLevel,
            'answers' => $answers,
            'notes' => null,
        ]);

        return view('foot-screening.result', compact('score', 'answers'));
    }

    public function footScreeningHistory()
    {
        $results = FootScreeningResult::where('user_id', $this->getDataEntryUserId())
            ->orderByDesc('created_at')
            ->get();

        return view('foot-screening.history', compact('results'));
    }

    public function footScreeningDetail($id)
    {
        $result = FootScreeningResult::where('id', $id)
            ->where('user_id', $this->getDataEntryUserId())
            ->firstOrFail();

        return view('foot-screening.detail', compact('result'));
    }

    public function tnt()
    {
        return view('tnt.index');
    }

    public function tntCalculate(Request $request)
    {
        $validated = $request->validate([
            'jk' => 'required|in:L,P',
            'height' => 'required|integer|min:50|max:300',
            'weight' => 'required|integer|min:20|max:500',
            'age' => 'required|integer|min:10|max:120',
            'activity' => 'required|in:1,2,3,4,5',
            'weight_status' => 'required|in:1,2,3',
        ]);

        $height = $validated['height'];
        $weight = $validated['weight'];
        $age = $validated['age'];
        $jk = $validated['jk'];
        $activity = (int) $validated['activity'];
        $weightStatus = (int) $validated['weight_status'];

        // Calculate ideal body weight (Broca formula)
        $bbi = $jk === 'L' ? ($height - 100) * 0.9 : ($height - 100) * 0.9;

        // BMI calculation
        $heightM = $height / 100;
        $bmi = $weight / ($heightM * $heightM);

        // Basal calorie needs
        $basal = $jk === 'L' ? ($bbi * 30) : ($bbi * 25);

        // Age adjustment
        if ($age >= 40 && $age <= 59) {
            $basal -= $basal * 0.05;
        } elseif ($age >= 60 && $age <= 69) {
            $basal -= $basal * 0.1;
        } elseif ($age >= 70) {
            $basal -= $basal * 0.2;
        }

        // Activity factor
        $activityFactor = [0, 1.2, 1.3, 1.5, 1.7, 1.9];
        $calorieNeeds = $basal * $activityFactor[$activity];

        // Weight status adjustment
        if ($weightStatus === 1) {
            $calorieNeeds -= 500;
        } // overweight - cut
        elseif ($weightStatus === 3) {
            $calorieNeeds += 500;
        } // underweight - add

        // Get diet recommendations
        $diets = Diet::with(['times.food'])->where('amount', '<=', $calorieNeeds)->orderBy('amount', 'desc')->first();

        // Save to database
        $tnt = TntCalculation::create([
            'user_id' => $this->getDataEntryUserId(),
            'jk' => $jk,
            'height' => $height,
            'weight' => $weight,
            'age' => $age,
            'activity' => $activity,
            'weight_status' => $weightStatus,
            'bmi' => round($bmi, 2),
            'bbi' => round($bbi, 2),
            'calorie_needs' => round($calorieNeeds),
            'diet_id' => $diets->id ?? null,
        ]);

        session()->flash('tnt_data', [
            'jk' => $jk,
            'height' => $height,
            'weight' => $weight,
            'age' => $age,
            'activity' => $activity,
            'weight_status' => $weightStatus,
            'bmi' => round($bmi, 2),
            'bbi' => round($bbi, 2),
            'calorie_needs' => round($calorieNeeds),
            'diet_id' => $diets->id ?? null,
        ]);

        return view('tnt.result', compact('bmi', 'bbi', 'calorieNeeds', 'diets', 'jk', 'height', 'weight', 'age', 'tnt'));
    }

    public function tntHistory()
    {
        $calculations = TntCalculation::with('diet')->where('user_id', $this->getDataEntryUserId())->latest()->paginate(10);

        return view('tnt.history', compact('calculations'));
    }

    public function tntDetail($id)
    {
        $calculation = TntCalculation::with('diet.times.food')->where('user_id', $this->getDataEntryUserId())->findOrFail($id);

        $bmi = $calculation->bmi;
        $bbi = $calculation->bbi;
        $calorieNeeds = $calculation->calorie_needs;
        $diets = $calculation->diet;
        $jk = $calculation->jk;
        $height = $calculation->height;
        $weight = $calculation->weight;
        $age = $calculation->age;

        return view('tnt.detail', compact('calculation', 'bmi', 'bbi', 'calorieNeeds', 'diets', 'jk', 'height', 'weight', 'age'));
    }

    public function tntSave(Request $request)
    {
        $data = $request->session()->get('tnt_data');

        if (! $data) {
            return redirect()->route('tnt')->with('error', 'Tidak ada data perhitungan yang tersimpan.');
        }

        $tnt = TntCalculation::create(array_merge($data, ['user_id' => $this->getDataEntryUserId()]));
        $request->session()->forget('tnt_data');

        return redirect()->route('tnt.detail', $tnt->id)->with('success', 'Perhitungan berhasil disimpan ke riwayat.');
    }

    public function pharmacology()
    {
        return view('pages.pharmacology');
    }

    public function profile()
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    public function profileEdit()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'required|string|max:20',
            'birthdate' => 'required|date',
            'jk' => 'nullable|in:L,P',
            'blood' => 'nullable|string|max:5',
            'tall' => 'required|integer|min:50|max:300',
            'weight' => 'required|integer|min:20|max:500',
            'is_smoke' => 'nullable|integer|in:0,1',
            'medical_history' => 'nullable|string',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'subdistrict' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:10',
        ]);

        $validated['birthdate'] = date('Y-m-d', strtotime($validated['birthdate']));
        $validated['is_smoke'] = $request->is_smoke ?? 0;
        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePassword()
    {
        return view('auth.change-password');
    }

    public function doChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', function ($attribute, $value, $fail) {
                if (! Hash::check($value, Auth::user()->password)) {
                    $fail('Kata sandi lama tidak sesuai.');
                }
            }],
            'new_password' => 'required|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Kata sandi berhasil diubah.');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function saveBloodSugar(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:GDP,GDS',
            'value' => 'required|integer|min:1|max:999',
            'category' => 'required|string|max:50',
            'notes' => 'nullable|string|max:255',
        ]);

        BloodSugarRecord::create([
            'user_id' => $this->getDataEntryUserId(),
            'type' => $validated['type'],
            'value' => $validated['value'],
            'category' => $validated['category'],
            'notes' => $validated['notes'] ?? null,
            'recorded_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function bloodSugarHistory(Request $request)
    {
        $query = BloodSugarRecord::where('user_id', $this->getDataEntryUserId())->orderBy('recorded_at', 'desc');

        $filterType = $request->get('type');
        if ($filterType && in_array($filterType, ['GDP', 'GDS'])) {
            $query->where('type', $filterType);
        }

        $records = $query->paginate(15)->withQueryString();

        $chartData = BloodSugarRecord::where('user_id', $this->getDataEntryUserId())
            ->orderBy('recorded_at', 'asc')
            ->limit(30)
            ->get();

        return view('blood-sugar.history', compact('records', 'filterType', 'chartData'));
    }

    public function recommendationFoot()
    {
        return view('pages.recommendation-foot');
    }

    public function weightLog()
    {
        $user = Auth::user();
        $rawLogs = WeightLog::where('user_id', $user->id)
            ->orderBy('recorded_at', 'desc')
            ->get();

        $prevWeight = null;
        $logs = $rawLogs->map(function ($log) use (&$prevWeight) {
            $log->change = $prevWeight !== null ? round($log->weight - $prevWeight, 1) : null;
            $log->bmi_value = $log->bmi ?? ($log->tall ? round($log->weight / (pow($log->tall / 100, 2)), 1) : null);
            $prevWeight = $log->weight;

            return $log;
        });

        $currentBmi = $user->tall ? round($user->weight / (pow($user->tall / 100, 2)), 1) : null;

        return view('health.weight', compact('user', 'logs', 'currentBmi'));
    }

    public function saveWeight(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'weight' => 'required|numeric|min:20|max:500',
            'tall' => 'nullable|integer|min:50|max:300',
            'notes' => 'nullable|string|max:500',
            'recorded_at' => 'required|date',
        ]);

        $tall = $validated['tall'] ?? $user->tall;
        $bmi = $tall ? round($validated['weight'] / (pow($tall / 100, 2)), 1) : null;

        WeightLog::create([
            'user_id' => $user->id,
            'weight' => $validated['weight'],
            'tall' => $tall,
            'bmi' => $bmi,
            'notes' => $validated['notes'] ?? null,
            'recorded_at' => $validated['recorded_at'],
        ]);

        $user->update([
            'weight' => (int) $validated['weight'],
            'tall' => $tall ?? $user->tall,
        ]);

        return redirect()->route('weight.log')->with('success', 'Data berat badan berhasil disimpan.');
    }
}
