<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\BankTransaction;


class CassoController extends Controller
{
    
    public function handleWebhook(Request $request)
{
    Log::info('Webhook được gọi từ Casso.');
    Log::info('Dữ liệu webhook:', $request->all());

    $token = $request->header('X-Casso-Token');

    if ($token !== env('CASSO_WEBHOOK_TOKEN')) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $data = $request->all();

    if (!isset($data['data'])) {
        return response()->json(['message' => 'No transaction data'], 400);
    }

    $transaction = $data['data'];  // ✅ Chỉ một giao dịch
    $description = $transaction['description'] ?? '';
    $amount = $transaction['amount'] ?? 0;

    Log::info("Checking transaction: {$description}, Amount: {$amount}");

    if (preg_match('/ORD[A-Z0-9]+/', $description, $matches)) {
        $order_number = $matches[0];
        $order = Order::where('order_number', $order_number)->first();

        if ($order && $order->payment_status !== 'paid' && $order->total_amount == $amount) {
            $order->payment_status = 'paid';
            $order->save();

            Log::info("Order {$order_number} marked as paid.");
        } else {
            Log::warning("Order {$order_number} not found or mismatched amount.");
        }
    } else {
        Log::warning("No order number found in description: {$description}");
    }

    return response()->json(['message' => 'OK']);
}

}
