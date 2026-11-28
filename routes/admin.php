<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FilmController;
use App\Http\Controllers\Admin\CategoryFilmController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewFilmController;
use App\Http\Controllers\Admin\RatingFilmController;

Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/', fn () => view('admin.index'))->name('admin.home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware('auth:admin')->name('admin.')->group(function () {
    Route::resource('films.categories', CategoryFilmController::class)
    ->only(['index', 'create', 'store', 'destroy']);
    Route::resource('countries', CountryController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('films', FilmController::class)->except(['show']);
    Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::patch('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore')->withTrashed();
Route::get('reviews', [ReviewFilmController::class, 'index'])->name('reviews.index');
Route::patch('reviews/{review}/approved', [ReviewFilmController::class, 'approved'])->name('reviews.approved');
Route::delete('reviews/{review}', [ReviewFilmController::class, 'destroy'])->name('reviews.destroy');
Route::get('ratings', [RatingFilmController::class, 'index'])->name('ratings.index');
Route::delete('ratings/{rating}', [RatingFilmController::class, 'destroy'])->name('ratings.destroy');
});