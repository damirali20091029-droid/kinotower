<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewFilmController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with([
                'film' => fn ($q) => $q->withTrashed(),
                'user' => fn ($q) => $q->withTrashed(),
            ])
            ->when($request->filled('film_id'), fn ($q) => $q->where('film_id', $request->film_id))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $films = Film::orderBy('name')->get();

        return view('admin.reviews.index', compact('reviews', 'films'));
    }

    public function approved(Review $review)
    {
        $review->update(['is_approved' => 1]);

        return back()->with('success', 'Отзыв одобрен');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Отзыв удалён');
    }
}