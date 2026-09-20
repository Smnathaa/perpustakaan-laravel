<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Models\Book;
use App\Models\Category;

Route::get('/', function () {
    return view('dashboard', [
        'titles' => Book::count(),
        'copies' => Book::sum('quantity'),
        'categoryCount' => Category::count(),
        'empty' => Book::where('quantity', 0)->count(),
        'recent' => Book::with('category')
            ->latest()
            ->take(5)
            ->get(),
    ]);
})->name('dashboard');

Route::get('/laporan', [BookController::class, 'report'])
    ->name('books.report');

Route::resource('books', BookController::class);

Route::resource('categories', CategoryController::class)
    ->only(['index', 'store', 'update', 'destroy']);

// Alamat login lama langsung menuju dashboard.
Route::redirect('/login', '/');