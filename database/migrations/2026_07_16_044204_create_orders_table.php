<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique();
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('service_id')->constrained();
            $table->decimal('total', 12, 2);
            $table->text('address');
            $table->string('regency_name', 100);
            $table->string('payment_status', 20)->default('unpaid');
            $table->string('order_status', 20)->default('pending');
            $table->string('midtrans_order_id', 100)->unique()->nullable();
            $table->string('midtrans_snap_token')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('payment_status');
            $table->index('order_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
