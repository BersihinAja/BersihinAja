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
