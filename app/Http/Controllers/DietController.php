<?php

namespace App\Http\Controllers;

use App\Http\Resources\DietResource;
use App\Models\Diet;
use Illuminate\Http\Request;

class DietController extends Controller
{
    public function show(Request $request, $amount){
        $diets = Diet::where('amount', "<=",$amount)->first();
        if(!$diets){
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada rekomendasi',
                'data' => []
            ], 200);
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => new DietResource($diets)
        ]);

    }
}
