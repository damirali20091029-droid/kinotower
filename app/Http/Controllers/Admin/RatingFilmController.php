<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingFilmController extends Controller
{
    public function index(Request $request)
    {
        $ratings = Rating::with([
                'film' => fn ($q) => $q->withTrashed(),
                'user' => fn ($q) => $q->withTrashed(),
            ])
            ->when($request->filled('film_id'), fn ($q) => $q->where('film_id', $request->film_id))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $average = $request->filled('film_id')
            ? Rating::where('film_id', $request->film_id)->avg('ball')
            : null;

        $films = Film::orderBy('name')->get();

        return view('admin.ratings.index', compact('ratings', 'films', 'average'));
    }

    public function destroy(Rating $rating)
    {
        $rating->delete();

        return back()->with('success', 'Оценка удалена');
    }
}