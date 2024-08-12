<?php

namespace App\Http\Controllers;

use App\Http\Resources\DietResource;
use App\Models\Diet;
use Illuminate\Http\Request;

class DietController extends Controller
{
    public function show(Request $request, $amount){
        $diets = Diet::where('amount', "<=",$amount)->first();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => new DietResource($diets)
        ]);

    }
}
