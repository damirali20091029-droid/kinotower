<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $films = Film::with(['country', 'categories'])
            ->when($request->filled('country_id'), fn ($q) => $q->where('country_id', $request->country_id))
            ->when($request->filled('category_id'), fn ($q) => $q->whereHas(
                'categories',
                fn ($c) => $c->where('categories.id', $request->category_id)
            ))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.films.index', [
            'films' => $films,
            'countries' => Country::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.films.form', [
            'countries' => Country::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Film::create($request->validate($this->rules()));

        return redirect()->route('admin.films.index')->with('success', 'Фильм добавлен');
    }

    public function edit(Film $film)
    {
        return view('admin.films.form', [
            'film' => $film,
            'countries' => Country::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Film $film)
    {
        $film->update($request->validate($this->rules()));

        return redirect()->route('admin.films.index')->with('success', 'Фильм изменён');
    }

    public function destroy(Film $film)
    {
        $film->delete();

        return redirect()->route('admin.films.index')->with('success', 'Фильм удалён');
    }

    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'country_id' => ['required', 'exists:countries,id'],
            'duration' => ['required', 'integer', 'min:1', 'max:65535'],
            'year_of_issue' => ['required', 'integer', 'between:1901,2155'],
            'age' => ['required', 'integer', 'min:0', 'max:21'],
            'link_img' => ['nullable', 'string', 'max:255'],
            'link_kinopoisk' => ['nullable', 'url', 'max:255'],
            'link_video' => ['required', 'url', 'max:255'],
        ];
    }
}