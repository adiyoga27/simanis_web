<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() {
        $user = Auth::user();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => User::where('id', $user->id)->first()
        ]);
    }
}