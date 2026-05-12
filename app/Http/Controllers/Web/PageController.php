<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\EducationCategory;
use App\Models\Education;
use App\Models\Diet;
use App\Models\TimeDiet;
use App\Models\FoodDiet;

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
        $payload = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'birthdate' => 'required|date',
            'phone' => 'required|string|max:20',
            'jk' => 'required|in:L,P',
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

        $payload['password'] = Hash::make($payload['password']);
        $payload['role'] = 'user';
        $payload['birthdate'] = date('Y-m-d', strtotime($payload['birthdate']));
        $payload['is_smoke'] = $request->is_smoke ?? 0;

        $user = User::create($payload);
        $user->sendEmailVerificationNotification();

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi.');
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
        return view('home.dashboard', compact('user'));
    }

    public function education()
    {
        $categories = EducationCategory::with('educations')->get();
        return view('education.index', compact('categories'));
    }

    public function educationDetail($slug)
    {
        $category = EducationCategory::where('slug', $slug)->firstOrFail();
        $educations = $category->educations()->get();
        return view('education.detail', compact('category', 'educations'));
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
        $score = $request->input('score', 0);
        $answers = $request->input('answers', []);
        return view('foot-screening.result', compact('score', 'answers'));
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
        if ($age >= 40 && $age <= 59) $basal -= $basal * 0.05;
        elseif ($age >= 60 && $age <= 69) $basal -= $basal * 0.1;
        elseif ($age >= 70) $basal -= $basal * 0.2;

        // Activity factor
        $activityFactor = [0, 1.2, 1.3, 1.5, 1.7, 1.9];
        $calorieNeeds = $basal * $activityFactor[$activity];

        // Weight status adjustment
        if ($weightStatus === 1) $calorieNeeds -= 500; // overweight - cut
        elseif ($weightStatus === 3) $calorieNeeds += 500; // underweight - add

        // Get diet recommendations
        $diets = Diet::with(['times.food'])->where('amount', '<=', $calorieNeeds)->orderBy('amount', 'desc')->first();

        return view('tnt.result', compact('bmi', 'bbi', 'calorieNeeds', 'diets', 'jk', 'height', 'weight', 'age'));
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
            'email' => 'required|email|unique:users,email,' . $user->id,
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

    public function recommendationFoot()
    {
        return view('pages.recommendation-foot');
    }
}
