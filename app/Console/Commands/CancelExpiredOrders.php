<?php

namespace App\Console\Commands;

use App\Services\OrderService;
use Illuminate\Console\Command;

class CancelExpiredOrders extends Command
{
    protected $signature = 'orders:cancel-expired';
    protected $description = 'Cancel orders that have passed their payment timeout';

    public function handle(OrderService $orderService): int
    {
        $count = $orderService->cancelExpired();
        $this->info("[CancelExpired] Cancelled {$count} orders.");
        return Command::SUCCESS;
    }
}
