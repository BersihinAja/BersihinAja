<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Livewire\HomePage;
use App\Livewire\ServiceList;
use App\Livewire\ServiceDetail;
use App\Livewire\Orders\CreateOrder;
use App\Livewire\Orders\OrderConfirm;
use App\Livewire\Orders\OrderReceipt;
use App\Livewire\Orders\OrderHistory;
use App\Livewire\Profile\ProfileEdit;
use App\Livewire\Admin;
use App\Livewire\Pekerja;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', HomePage::class)->name('home');
Route::get('/services', ServiceList::class)->name('services.index');
Route::get('/services/{service:slug}', ServiceDetail::class)->name('services.show');

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
    Route::get('/orders/create/{service:slug}', CreateOrder::class)->name('orders.create');
    Route::get('/orders/{order}/confirm', OrderConfirm::class)->name('orders.confirm');
    Route::get('/orders/{order}/receipt', OrderReceipt::class)->name('orders.receipt');
    Route::get('/orders/history', OrderHistory::class)->name('orders.history');

    // Profile
    Route::get('/profile', ProfileEdit::class)->name('profile.edit');
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
    Route::get('/dashboard', Pekerja\Dashboard::class)->name('dashboard');
    Route::get('/orders', Pekerja\OrderList::class)->name('orders.index');
    Route::get('/customers', Pekerja\CustomerList::class)->name('customers.index');
});

// Admin Dashboard
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Admin\Dashboard::class)->name('dashboard');
    Route::get('/services', Admin\ServiceManager::class)->name('services.index');
    Route::get('/users', Admin\UserManager::class)->name('users.index');
    Route::get('/orders', Admin\OrderManager::class)->name('orders.index');
});

require __DIR__.'/auth.php';
