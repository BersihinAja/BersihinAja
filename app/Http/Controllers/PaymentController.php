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
