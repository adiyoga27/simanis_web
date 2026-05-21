<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\EducationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminEducationController extends Controller
{
    // ─── CATEGORIES ────────────────────────────────────────────────────

    public function index()
    {
        $categories = EducationCategory::withCount('educations')->orderBy('created_at', 'desc')->get();

        return view('admin.education.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'color'       => 'nullable|string|max:30',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        EducationCategory::create($validated);

        return redirect()->route('admin.education.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = EducationCategory::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'color'       => 'nullable|string|max:30',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $category->update($validated);

        return redirect()->route('admin.education.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyCategory($id)
    {
        $category = EducationCategory::findOrFail($id);
        $category->educations()->delete();
        $category->delete();

        return redirect()->route('admin.education.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    // ─── ARTICLES ──────────────────────────────────────────────────────

    public function articles($categoryId)
    {
        $category = EducationCategory::findOrFail($categoryId);
        $educations = $category->educations()->orderBy('created_at', 'desc')->get();

        return view('admin.education.articles', compact('category', 'educations'));
    }

    public function createArticle($categoryId)
    {
        $category = EducationCategory::findOrFail($categoryId);

        return view('admin.education.article-form', [
            'category'  => $category,
            'education' => new Education,
        ]);
    }

    public function storeArticle(Request $request, $categoryId)
    {
        $category = EducationCategory::findOrFail($categoryId);

        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['education_category_id'] = $category->id;
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('education', 'public');
        }

        Education::create($validated);

        return redirect()->route('admin.education.articles', $category->id)
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function editArticle($id)
    {
        $education = Education::with('category')->findOrFail($id);

        return view('admin.education.article-form', [
            'category'  => $education->category,
            'education' => $education,
        ]);
    }

    public function updateArticle(Request $request, $id)
    {
        $education = Education::findOrFail($id);

        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('education', 'public');
        }

        $education->update($validated);

        return redirect()->route('admin.education.articles', $education->education_category_id)
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroyArticle($id)
    {
        $education = Education::findOrFail($id);
        $catId = $education->education_category_id;
        $education->delete();

        return redirect()->route('admin.education.articles', $catId)
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
