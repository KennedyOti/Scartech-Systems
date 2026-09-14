<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Portal\DashboardController;
use App\Http\Controllers\Portal\ProductController as PortalProductController;
use App\Http\Controllers\Portal\ProjectController as PortalProjectController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{project:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::get('/request-a-quote', [QuoteRequestController::class, 'create'])->name('quote.create');
Route::post('/request-a-quote', [QuoteRequestController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('quote.store');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::middleware(['auth', 'admin', 'verified'])->prefix('portal')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::name('portal.')->group(function () {
        Route::resource('projects', PortalProjectController::class);
        Route::resource('products', PortalProductController::class);
    });
});

Route::middleware(['auth', 'admin'])->prefix('portal')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
