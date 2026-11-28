<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryFilmController extends Controller
{
    public function index(Film $film)
    {
        $categories = $film->categories()->orderBy('name')->get();

        return view('admin.category_films.index', compact('film', 'categories'));
    }

    public function create(Film $film)
    {
        $categories = Category::whereNotIn('id', $film->categories()->pluck('categories.id'))
            ->orderBy('name')
            ->get();

        return view('admin.category_films.create', compact('film', 'categories'));
    }

    public function store(Request $request, Film $film)
    {
        $data = $request->validate([
            'category_id' => ['required', Rule::exists('categories', 'id')->whereNull('deleted_at')],
        ]);

        if ($film->categories()->where('categories.id', $data['category_id'])->exists()) {
            return back()->with('error', 'Этот жанр уже добавлен к фильму');
        }

        $film->categories()->attach($data['category_id']);

        return redirect()->route('admin.films.categories.index', $film)
            ->with('success', 'Жанр добавлен к фильму');
    }

    public function destroy(Film $film, Category $category)
    {
        $film->categories()->detach($category->id);

        return redirect()->route('admin.films.categories.index', $film)
            ->with('success', 'Жанр удалён у фильма');
    }
}