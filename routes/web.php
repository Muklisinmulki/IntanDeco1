<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Tambahkan route baru untuk mengambil data catalog
Route::get('/api/catalogs', [CatalogController::class, 'getCatalogs']);
Route::get('/api/catalogsfull', [CatalogController::class, 'getCatalogsFull']);
Route::get('/api/catalogstotal', [CatalogController::class, 'getCatalogsTotal']);
Route::get('/api/categories', [CategoryController::class, 'getCategories']);


Route::get('/api/catalog-by-category', [CatalogController::class, 'getCatalogByCategory']);
Route::get('/api/catalogs-by-date', [CatalogController::class, 'getCatalogsByDate']);
Route::get('/dashboard/catalog-chart', [CatalogController::class, 'getCatalogChartData']);

Route::get('/api/check-updates', [CatalogController::class, 'checkUpdates']);

Route::get('/today-catalogs-count', [CatalogController::class, 'countTodayCatalogs']);



Route::get('/about', fn() => Inertia::render('About'));
Route::get('/product', fn() => Inertia::render('Product'));

Route::get('/contact', fn() => Inertia::render('Contact'));

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    // Catalog
    Route::resource('catalog', CatalogController::class);
    // Categories
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/dashboard/category-count', [CategoryController::class, 'count'])->name('categories.count');
});