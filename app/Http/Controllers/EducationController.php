<?php

namespace App\Http\Controllers;

use App\Http\Resources\Education\EducationCategoryResource;
use App\Http\Resources\Education\EducationResource;
use App\Models\Education;
use App\Models\EducationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $education = EducationCategory::with('educations')->get();

        return response()->json(
            [
                'status' => true,
                'message' => 'success',
                'data' => EducationCategoryResource::collection($education),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            EducationCategory::create([
                'title' => $request->title,
               'slug' => Str::slug($request->title),
            ]);
            return response()->json([
                'status' => true,
            'message' => 'Education category created successfully',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
            'message' => 'Education failed created successfully',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $education = Education::whereHas('category', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->get();

        return response()->json(
            [
                'status' => true,
                'message' => 'success',
                'data' => EducationResource::collection($education)
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function storeEducation(Request $request, string $slug) {
        try {
            $educationCategory = EducationCategory::where('slug', $slug)->first();
            $educationCategory->educations()->create([
                'title' => $request->title,
                'content' => $request->content,
                'slug' => Str::slug($request->title),
                'image' => $request->image->store('education', 'public'),
            ]);
            return response()->json([
               'status' => true,
            'message' => 'Education created successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
               'status' => false,
            'message' => 'Education failed created successfully'. $th->getMessage(),
            ]);
        }
    }
}
