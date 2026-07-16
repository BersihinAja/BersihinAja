<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Pekerja;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');

// Google OAuth
Route::get('/auth/google', [SocialiteController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'callback']);

// Midtrans webhook (no CSRF, no auth)
Route::post('/midtrans/webhook', [PaymentController::class, 'handleWebhook'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('midtrans.webhook');

// Authenticated customer routes
Route::middleware(['auth'])->group(function () {
    // Orders
    Route::get('/orders/create/{service:slug}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
    Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');

    // Payment
    Route::post('/payment/{order}/snap-token', [PaymentController::class, 'getSnapToken'])->name('payment.snap-token');

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard redirect
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('admin')) return redirect('/admin/dashboard');
    if ($user->hasRole('pekerja')) return redirect('/pekerja/dashboard');
    return redirect('/');
})->middleware(['auth'])->name('dashboard');

// Pekerja (Worker) Dashboard
Route::middleware(['auth', 'role:pekerja'])->prefix('pekerja')->name('pekerja.')->group(function () {
    Route::get('/dashboard', [Pekerja\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [Pekerja\OrderController::class, 'index'])->name('orders.index');
    Route::put('/orders/{order}/complete', [Pekerja\OrderController::class, 'complete'])->name('orders.complete');
    Route::get('/customers', [Pekerja\CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{user}', [Pekerja\CustomerController::class, 'show'])->name('customers.show');
});

// Admin Dashboard
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/services', Admin\ServiceController::class)->except(['show']);
    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
});

require __DIR__.'/auth.php';
