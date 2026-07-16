# BersihinAja — Route Documentation

> Auto-generated route map for the BersihinAja cleaning-service Laravel project.

---

## 1. Route File Source Code

### 1.1 `routes/web.php`

```php
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
```

### 1.2 `routes/api.php`

```php
<?php

use App\Http\Controllers\Api\RegionController;
use Illuminate\Support\Facades\Route;

Route::get('/regions/provinces', [RegionController::class, 'provinces']);
Route::get('/regions/regencies/{provinceId}', [RegionController::class, 'regencies']);
```

### 1.3 `routes/auth.php`

```php
<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
```

### 1.4 `routes/ai.php`

```php
<?php

use App\Mcp\Servers\BersihinAjaServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp/bersihinaja', BersihinAjaServer::class)
    ->middleware(['throttle:mcp']);

Mcp::local('bersihinaja', BersihinAjaServer::class);
```

---

## 2. Controller Source Code

### 2.1 Customer Controllers

#### `HomeController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('home', compact('services'));
    }
}
```

#### `ServiceController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use App\Services\RegionService;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('packages')->get();
        return view('services.index', compact('services'));
    }

    public function show(Service $service, RegionService $regionService)
    {
        $service->load('packages');
        $provinces = $regionService->getProvinces();
        return view('services.show', compact('service', 'provinces'));
    }
}
```

#### `OrderController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request, Service $service)
    {
        $service->load('packages');
        $regencyName = $request->query('regency_name', '');
        $regencyId = $request->query('regency_id', '');

        $workers = User::workers()->available()->inRegency($regencyId)->get();

        return view('orders.create', compact('service', 'workers', 'regencyName', 'regencyId'));
    }

    public function store(StoreOrderRequest $request, OrderService $orderService)
    {
        $order = $orderService->create([
            'customer_id' => auth()->id(),
            'service_id' => $request->service_id,
            'worker_ids' => $request->worker_ids,
            'package_ids' => $request->package_ids ?? [],
            'address' => $request->address,
            'regency_name' => $request->regency_name,
        ]);

        return redirect()->route('orders.confirm', $order);
    }

    public function confirm(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['service', 'workers', 'packages']);
        return view('orders.confirm', compact('order'));
    }

    public function receipt(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['service', 'workers', 'packages', 'review']);
        return view('orders.receipt', compact('order'));
    }

    public function history()
    {
        $orders = Order::forCustomer(auth()->id())
            ->with(['service', 'review'])
            ->latest()
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }
}
```

#### `PaymentController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function getSnapToken(Order $order, MidtransService $midtransService)
    {
        $this->authorize('view', $order);
        $snapToken = $midtransService->createSnapToken($order);
        return response()->json(['snap_token' => $snapToken]);
    }

    public function handleWebhook(Request $request, MidtransService $midtransService)
    {
        $midtransService->handleNotification($request->all());
        return response()->json(['status' => 'ok']);
    }
}
```

#### `ReviewController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request)
    {
        Review::create([
            'order_id' => $request->order_id,
            'customer_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('orders.history')
            ->with('success', 'Review berhasil dikirim!');
    }
}
```

#### `ProfileController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
```

### 2.2 Admin Controllers

#### `Admin\DashboardController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'total_users' => User::count(),
            'total_customers' => User::role('customer')->count(),
            'total_workers' => User::role('pekerja')->count(),
            'active_workers' => User::role('pekerja')->where('status', 'working')->count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'in_progress_orders' => Order::where('order_status', 'in_progress')->count(),
        ];

        $recentOrders = Order::with(['customer', 'service'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
```

#### `Admin\ServiceController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::withCount('orders')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $packages = Package::all();
        return view('admin.services.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'room_size' => 'required|string|max:20',
            'max_hours' => 'required|integer|min:1',
            'estimation' => 'required|string|max:100',
            'cleaners_required' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'package_ids' => 'nullable|array',
            'package_ids.*' => 'exists:packages,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service = Service::create($validated);

        if (isset($validated['package_ids'])) {
            $service->packages()->sync($validated['package_ids']);
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        $packages = Package::all();
        $service->load('packages');
        return view('admin.services.edit', compact('service', 'packages'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'room_size' => 'required|string|max:20',
            'max_hours' => 'required|integer|min:1',
            'estimation' => 'required|string|max:100',
            'cleaners_required' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'package_ids' => 'nullable|array',
            'package_ids.*' => 'exists:packages,id',
        ]);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($validated);
        $service->packages()->sync($validated['package_ids'] ?? []);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}
```

#### `Admin\UserController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role', 'all');

        $query = User::query();
        if ($role !== 'all') {
            $query->role($role);
        }

        $users = $query->withCount('orders')->latest()->paginate(15);

        return view('admin.users.index', compact('users', 'role'));
    }

    public function show(User $user)
    {
        $user->load(['orders' => function ($q) {
            $q->with('service')->latest()->take(10);
        }, 'roles']);

        return view('admin.users.show', compact('user'));
    }
}
```

#### `Admin\OrderController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Order::with(['customer', 'service']);
        if ($status !== 'all') {
            $query->where('order_status', $status);
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'service', 'workers', 'packages', 'review']);
        return view('admin.orders.show', compact('order'));
    }
}
```

### 2.3 Pekerja (Worker) Controllers

#### `Pekerja\DashboardController.php`

```php
<?php

namespace App\Http\Controllers\Pekerja;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'active_orders' => $user->assignedOrders()->where('order_status', 'in_progress')->count(),
            'completed_orders' => $user->assignedOrders()->where('order_status', 'completed')->count(),
            'total_earnings' => $user->assignedOrders()->where('payment_status', 'paid')->sum('total'),
            'status' => $user->status,
        ];

        $recentOrders = $user->assignedOrders()
            ->with(['customer', 'service'])
            ->latest()
            ->take(5)
            ->get();

        return view('pekerja.dashboard', compact('stats', 'recentOrders'));
    }
}
```

#### `Pekerja\OrderController.php`

```php
<?php

namespace App\Http\Controllers\Pekerja;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->query('status', 'all');

        $query = $user->assignedOrders()->with(['customer', 'service', 'packages']);

        if ($status !== 'all') {
            $query->where('order_status', $status);
        }

        $orders = $query->latest()->paginate(10);

        return view('pekerja.orders', compact('orders', 'status'));
    }

    public function complete(Order $order, OrderService $orderService)
    {
        // Verify this worker is assigned to this order
        $user = Auth::user();
        if (!$order->workers->contains('id', $user->id)) {
            abort(403);
        }

        $orderService->complete($order);

        return redirect()->route('pekerja.orders.index')
            ->with('success', 'Pesanan berhasil diselesaikan!');
    }
}
```

#### `Pekerja\CustomerController.php`

```php
<?php

namespace App\Http\Controllers\Pekerja;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get unique customers from worker's assigned orders
        $customerIds = $user->assignedOrders()->pluck('customer_id')->unique();
        $customers = User::whereIn('id', $customerIds)
            ->withCount(['orders'])
            ->paginate(10);

        return view('pekerja.customers', compact('customers'));
    }

    public function show(User $user)
    {
        $worker = Auth::user();

        // Only show customers this worker has served
        $orders = $worker->assignedOrders()
            ->where('customer_id', $user->id)
            ->with(['service', 'review'])
            ->latest()
            ->get();

        return view('pekerja.customer-detail', compact('user', 'orders'));
    }
}
```

### 2.4 API Controllers

#### `Api\RegionController.php`

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RegionService;

class RegionController extends Controller
{
    public function provinces(RegionService $regionService)
    {
        return response()->json($regionService->getProvinces());
    }

    public function regencies(string $provinceId, RegionService $regionService)
    {
        return response()->json($regionService->getRegencies($provinceId));
    }
}
```

---

## 3. Comprehensive Route Map

### 3.1 Public Routes (No Auth Required)

| Method | URL Path | Controller@method | Route Name | Layout | Description |
|--------|----------|-------------------|------------|--------|-------------|
| `GET` | `/` | `HomeController@index` | `home` | `layouts.app` | Landing page — lists all cleaning services |
| `GET` | `/services` | `ServiceController@index` | `services.index` | `layouts.app` | Browse all services with packages |
| `GET` | `/services/{service:slug}` | `ServiceController@show` | `services.show` | `layouts.app` | Service detail page with province selector |
| `GET` | `/auth/google` | `Auth\SocialiteController@redirect` | `auth.google` | — (redirect) | Redirect to Google OAuth login |
| `GET` | `/auth/google/callback` | `Auth\SocialiteController@callback` | — | — (redirect) | Google OAuth callback handler |
| `POST` | `/midtrans/webhook` | `PaymentController@handleWebhook` | `midtrans.webhook` | — (JSON) | Midtrans payment notification webhook (no CSRF) |

### 3.2 Auth Routes — Guest Only (`middleware: guest`)

| Method | URL Path | Controller@method | Route Name | Layout | Description |
|--------|----------|-------------------|------------|--------|-------------|
| `GET` | `/register` | `Auth\RegisteredUserController@create` | `register` | `layouts.guest` | Registration form |
| `POST` | `/register` | `Auth\RegisteredUserController@store` | — | — (redirect) | Process registration |
| `GET` | `/login` | `Auth\AuthenticatedSessionController@create` | `login` | `layouts.guest` | Login form |
| `POST` | `/login` | `Auth\AuthenticatedSessionController@store` | — | — (redirect) | Process login |
| `GET` | `/forgot-password` | `Auth\PasswordResetLinkController@create` | `password.request` | `layouts.guest` | Forgot password form |
| `POST` | `/forgot-password` | `Auth\PasswordResetLinkController@store` | `password.email` | — (redirect) | Send password reset email |
| `GET` | `/reset-password/{token}` | `Auth\NewPasswordController@create` | `password.reset` | `layouts.guest` | Reset password form |
| `POST` | `/reset-password` | `Auth\NewPasswordController@store` | `password.store` | — (redirect) | Process password reset |

### 3.3 Auth Routes — Authenticated (`middleware: auth`)

| Method | URL Path | Controller@method | Route Name | Layout | Description |
|--------|----------|-------------------|------------|--------|-------------|
| `GET` | `/verify-email` | `Auth\EmailVerificationPromptController` | `verification.notice` | `layouts.guest` | Email verification prompt |
| `GET` | `/verify-email/{id}/{hash}` | `Auth\VerifyEmailController` | `verification.verify` | — (redirect) | Verify email address (signed URL) |
| `POST` | `/email/verification-notification` | `Auth\EmailVerificationNotificationController@store` | `verification.send` | — (redirect) | Resend verification email |
| `GET` | `/confirm-password` | `Auth\ConfirmablePasswordController@show` | `password.confirm` | `layouts.guest` | Confirm password form |
| `POST` | `/confirm-password` | `Auth\ConfirmablePasswordController@store` | — | — (redirect) | Process password confirmation |
| `PUT` | `/password` | `Auth\PasswordController@update` | `password.update` | — (redirect) | Update password |
| `POST` | `/logout` | `Auth\AuthenticatedSessionController@destroy` | `logout` | — (redirect) | Logout and destroy session |

### 3.4 Customer Routes (`middleware: auth`)

| Method | URL Path | Controller@method | Route Name | Layout | Description |
|--------|----------|-------------------|------------|--------|-------------|
| `GET` | `/dashboard` | Closure (redirect) | `dashboard` | — (redirect) | Role-based dashboard redirect |
| `GET` | `/orders/create/{service:slug}` | `OrderController@create` | `orders.create` | `layouts.app` | Order creation form for a specific service |
| `POST` | `/orders` | `OrderController@store` | `orders.store` | — (redirect) | Submit new order |
| `GET` | `/orders/{order}/confirm` | `OrderController@confirm` | `orders.confirm` | `layouts.app` | Order confirmation / payment page |
| `GET` | `/orders/{order}/receipt` | `OrderController@receipt` | `orders.receipt` | `layouts.app` | Order receipt / completion page |
| `GET` | `/orders/history` | `OrderController@history` | `orders.history` | `layouts.app` | Customer order history (paginated) |
| `POST` | `/payment/{order}/snap-token` | `PaymentController@getSnapToken` | `payment.snap-token` | — (JSON) | Generate Midtrans Snap token |
| `POST` | `/reviews` | `ReviewController@store` | `reviews.store` | — (redirect) | Submit a review for a completed order |
| `GET` | `/profile` | `ProfileController@edit` | `profile.edit` | `layouts.app` | Edit profile form |
| `PATCH` | `/profile` | `ProfileController@update` | `profile.update` | — (redirect) | Update profile information |
| `DELETE` | `/profile` | `ProfileController@destroy` | `profile.destroy` | — (redirect) | Delete account |

### 3.5 Pekerja (Worker) Routes (`middleware: auth, role:pekerja`)

| Method | URL Path | Controller@method | Route Name | Layout | Description |
|--------|----------|-------------------|------------|--------|-------------|
| `GET` | `/pekerja/dashboard` | `Pekerja\DashboardController@index` | `pekerja.dashboard` | `layouts.pekerja` | Worker dashboard with stats & recent orders |
| `GET` | `/pekerja/orders` | `Pekerja\OrderController@index` | `pekerja.orders.index` | `layouts.pekerja` | Worker's assigned orders list (filterable) |
| `PUT` | `/pekerja/orders/{order}/complete` | `Pekerja\OrderController@complete` | `pekerja.orders.complete` | — (redirect) | Mark an order as completed |
| `GET` | `/pekerja/customers` | `Pekerja\CustomerController@index` | `pekerja.customers.index` | `layouts.pekerja` | List of customers the worker has served |
| `GET` | `/pekerja/customers/{user}` | `Pekerja\CustomerController@show` | `pekerja.customers.show` | `layouts.pekerja` | Customer detail with order history |

### 3.6 Admin Routes (`middleware: auth, role:admin`)

| Method | URL Path | Controller@method | Route Name | Layout | Description |
|--------|----------|-------------------|------------|--------|-------------|
| `GET` | `/admin/dashboard` | `Admin\DashboardController@index` | `admin.dashboard` | `layouts.admin` | Admin dashboard with platform stats |
| `GET` | `/admin/services` | `Admin\ServiceController@index` | `admin.services.index` | `layouts.admin` | List all services with order counts |
| `GET` | `/admin/services/create` | `Admin\ServiceController@create` | `admin.services.create` | `layouts.admin` | Create new service form |
| `POST` | `/admin/services` | `Admin\ServiceController@store` | `admin.services.store` | — (redirect) | Store new service |
| `GET` | `/admin/services/{service}/edit` | `Admin\ServiceController@edit` | `admin.services.edit` | `layouts.admin` | Edit service form |
| `PUT/PATCH` | `/admin/services/{service}` | `Admin\ServiceController@update` | `admin.services.update` | — (redirect) | Update service |
| `DELETE` | `/admin/services/{service}` | `Admin\ServiceController@destroy` | `admin.services.destroy` | — (redirect) | Delete service |
| `GET` | `/admin/users` | `Admin\UserController@index` | `admin.users.index` | `layouts.admin` | List all users (filterable by role) |
| `GET` | `/admin/users/{user}` | `Admin\UserController@show` | `admin.users.show` | `layouts.admin` | User detail with recent orders |
| `GET` | `/admin/orders` | `Admin\OrderController@index` | `admin.orders.index` | `layouts.admin` | List all orders (filterable by status) |
| `GET` | `/admin/orders/{order}` | `Admin\OrderController@show` | `admin.orders.show` | `layouts.admin` | Order detail with all relations |

### 3.7 API Routes (prefix: `/api`)

| Method | URL Path | Controller@method | Route Name | Layout | Description |
|--------|----------|-------------------|------------|--------|-------------|
| `GET` | `/api/regions/provinces` | `Api\RegionController@provinces` | — | — (JSON) | Get list of Indonesian provinces |
| `GET` | `/api/regions/regencies/{provinceId}` | `Api\RegionController@regencies` | — | — (JSON) | Get regencies for a province |

### 3.8 MCP / AI Routes (`routes/ai.php`)

| Protocol | Path / Name | Handler | Description |
|----------|-------------|---------|-------------|
| HTTP (SSE) | `/mcp/bersihinaja` | `BersihinAjaServer` | Web-accessible MCP server (throttled) |
| stdio | `bersihinaja` | `BersihinAjaServer` | Local MCP server for CLI tools |

---

## 4. Layout Summary

| Layout | Used By | Description |
|--------|---------|-------------|
| `layouts.app` | Customer-facing pages (`home`, `services.*`, `orders.*`, `profile.*`) | Main customer layout with navbar, footer |
| `layouts.guest` | Auth pages (`auth.*` — login, register, password reset, verify email) | Minimal guest layout for authentication |
| `layouts.pekerja` | Worker pages (`pekerja.*`) | Worker dashboard layout with sidebar |
| `layouts.admin` | Admin pages (`admin.*`) | Admin dashboard layout with sidebar |
| — (JSON) | API endpoints, payment webhook, snap-token | No layout — returns JSON response |
| — (redirect) | POST/PUT/PATCH/DELETE actions | No layout — redirects after processing |

---

## 5. Route Statistics

| Category | Count |
|----------|-------|
| Total unique URL patterns | ~42 |
| Public (no auth) | 6 |
| Guest-only (auth) | 8 |
| Authenticated (auth) | 7 |
| Customer routes | 11 |
| Pekerja routes | 5 |
| Admin routes | 11 |
| API routes | 2 |
| MCP routes | 2 |
