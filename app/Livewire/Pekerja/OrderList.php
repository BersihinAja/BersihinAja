<?php

namespace App\Livewire\Pekerja;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

    public string $tab = 'active'; // active, pool
    public string $status = 'all';

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingTab()
    {
        $this->resetPage();
    }

    public function claimOrder($orderId)
    {
        $user = Auth::user();

        if ($user->status !== 'available') {
            session()->flash('error', 'Akun Anda harus terverifikasi dan aktif untuk mengambil pesanan.');
            return;
        }

        try {
            DB::transaction(function () use ($orderId, $user) {
                // Lock the order for update to prevent double claiming
                $order = Order::where('id', $orderId)
                    ->where('order_status', 'pending')
                    ->where('payment_status', 'paid')
                    ->where('regency_name', $user->regency_name)
                    ->lockForUpdate()
                    ->first();

                if (!$order) {
                    throw new \Exception('Pesanan ini sudah diambil oleh pekerja lain atau tidak lagi tersedia.');
                }

                $order->update(['order_status' => 'assigned']);
                $order->workers()->attach($user->id);
            });

            session()->flash('success', 'Berhasil mengambil pekerjaan! Silakan menuju lokasi.');
            $this->tab = 'active';
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function startTrip(Order $order)
    {
        $user = Auth::user();
        if (!$order->workers->contains('id', $user->id)) {
            abort(403);
        }

        $order->update(['order_status' => 'on_the_way']);
        session()->flash('success', 'Perjalanan dimulai. Hati-hati di jalan!');
    }

    public function startWork(Order $order, float $lat, float $lng)
    {
        $user = Auth::user();
        if (!$order->workers->contains('id', $user->id)) {
            abort(403);
        }

        // Haversine geofencing distance check
        $earthRadius = 6371000; // in meters
        $latFrom = deg2rad($lat);
        $lonFrom = deg2rad($lng);
        $latTo = deg2rad($order->latitude);
        $lonTo = deg2rad($order->longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        $distance = $angle * $earthRadius; // in meters

        if ($distance > 200) {
            $distanceKm = round($distance / 1000, 2);
            session()->flash('error', "Gagal memulai pekerjaan. Lokasi Anda berjarak {$distanceKm} km. Radius toleransi masuk kerja maksimal 200 meter.");
            return;
        }

        $order->update(['order_status' => 'working']);
        session()->flash('success', 'Pekerjaan dimulai! Selamat membersihkan.');
    }

    public function completeOrder(Order $order, OrderService $orderService)
    {
        $user = Auth::user();
        if (!$order->workers->contains('id', $user->id)) {
            abort(403);
        }

        $orderService->complete($order);
        session()->flash('success', 'Pesanan ' . $order->order_number . ' telah selesai diselesaikan!');
    }

    public function render()
    {
        $user = Auth::user();
        
        if ($this->tab === 'active') {
            $query = $user->assignedOrders()->with(['customer', 'service', 'packages']);
            if ($this->status !== 'all') {
                $query->where('order_status', $this->status);
            }
            $orders = $query->latest()->paginate(10);
        } else {
            // Pool logic: unpaid/pending orders matching the worker's regency
            $orders = Order::with(['customer', 'service', 'packages'])
                ->where('order_status', 'pending')
                ->where('payment_status', 'paid')
                ->where('regency_name', $user->regency_name)
                ->latest()
                ->paginate(10);
        }

        return view('livewire.pekerja.order-list', [
            'orders' => $orders,
        ])->layout('layouts.pekerja', ['title' => 'Pesanan Saya']);
    }
}
