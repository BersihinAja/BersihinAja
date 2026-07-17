<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\Review;
use Livewire\Component;

class OrderReceipt extends Component
{
    public Order $order;
    
    // Review form inputs
    public int $rating = 5;
    public string $comment = '';

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->order->load(['service', 'workers', 'packages', 'review']);
    }

    public function submitReview()
    {
        $this->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
        ]);

        $review = Review::create([
            'order_id' => $this->order->id,
            'customer_id' => auth()->id(),
            'rating' => $this->rating,
            'comment' => $this->comment ?: null,
        ]);

        $this->order->setRelation('review', $review);
        session()->flash('success', 'Ulasan Anda berhasil dikirim!');
    }

    public function render()
    {
        return view('livewire.orders.order-receipt')
            ->layout('layouts.guest-public', ['title' => 'Detail Pesanan — BersihinAja']);
    }
}
