<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Resources\Auth\AuthResource as AuthAuthResource;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function verify(Request $request)
    {
        $credential = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
      
        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return redirect()->back()->withErrors('Username or password invalid !!!');
    }
    public function login(Request $request)
    {
        $credential = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        $us = User::where('username', $credential['username'])->whereNull('email_verified_at')->first();
        if($us) {
            return response()->json([
               'status' => false,
               'message' => 'Email Belum di Verifikasi',
               'data' => $us
            ], 403);
        }
        if (Auth::attempt($credential)) {
            $user = Auth::user();
            $token = $user->createToken(
                $user->username.'_'.Carbon::now(), // The name of the token
                ['*'],                         // Whatever abilities you want
                Carbon::now()->addDays(360)     // The expiration date
            );
            
            $user['token'] = $token;
            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'data' =>  (new AuthAuthResource($user)),
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Username or password invalid !!!'
        ], 200);
    }
    public function registration(RegistrationRequest $request){
       
        try {
            $payload = array(
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role?? 'user',
                'birthdate' => Carbon::createFromFormat('d-m-Y', $request->birthdate),
                'phone' => $request->phone,
                'jk' => $request->jk,
                'is_smoke' => $request->is_smoke,
                'medical_history' => $request->medical_history?? null,
                'province' => $request->province,
                'city' => $request->city,
                'subdistrict' => $request->subdistrict,
                'village' => $request->village,
                'address' => $request->address,
                'kode_pos' => $request->kode_pos?? null,
            );
            

            if($request->has('avatar')){
                $payload['avatar'] = Storage::put('images/avatars', $request->file('avatar'));
            }
            User::create($payload);

            return response()->json([
               'status' => true,
               'message' => 'Berhasil registrasi, silahkan check email anda untuk verifikasi !!!'
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()  //error message
            ]);
        }
    }
    public function updateProfile(Request $request){
       
        try {
            $payload = array(
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role?? 'user',
                'birthdate' => Carbon::createFromFormat('d-m-Y', $request->birthdate),
                'phone' => $request->phone,
                'jk' => $request->jk,
                'is_smoke' => $request->is_smoke,
                'medical_history' => $request->medical_history?? null,
                'province' => $request->province,
                'city' => $request->city,
                'subdistrict' => $request->subdistrict,
                'village' => $request->village,
                'address' => $request->address,
                'kode_pos' => $request->kode_pos?? null,
            );
            

            if($request->has('avatar')){
                $payload['avatar'] = Storage::put('images/avatars', $request->file('avatar'));
            }
            User::where('id', Auth::user()->id)->update($payload);

            return response()->json([
               'status' => true,
               'message' => 'Berhasil merubah profile anda ...'
            ], 201);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'status' => false,
                'message' => "Gagal Merubah Profile Anda !".$th->getMessage()  //error message
            ]);
        }
    }

    function resendVerification(Request $request) {
            try {
                $user = User::where('email', $request->email)->first();
                if($user) {
                    $token = $user->createToken(
                        $user->username.'_'.Carbon::now(), // The name of the token
                        ['*'],                         // Whatever abilities you want
                        Carbon::now()->addDays(360)     // The expiration date
                    );
                    
                    $user['token'] = $token;
                    $user->sendEmailVerificationNotification();
                    return response()->json([
                       'status' => true,
                       'message' => 'Verifikasi link telah dikirim ke email anda, silahkan cek dan verifikasi!'
                    ], 200);
                } else {
                    return response()->json([
                       'status' => false,
                       'message' => 'Email not found'
                    ], 200);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
    }

    public function verifyEmail(Request $request)
        {
            if (!auth()->check()) {
                auth()->loginUsingId($request->route('id'));
            }

            if ($request->route('id') != $request->user()->getKey()) {
                throw new AuthorizationException();
            }

            if ($request->user()->hasVerifiedEmail()) {
                return redirect('success-verification');
            }

            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }

            return redirect('success-verification')->with('verified', true);
        }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
