<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Models\Order;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Webhook từ Casso
Route::post('/casso/webhook', [OrderController::class, 'handleWebhook']);

// API kiểm tra trạng thái thanh toán
Route::get('/check-payment-status/{orderId}', function ($orderId) {
    $order = Order::findOrFail($orderId);
    return response()->json(['paid' => $order->payment_status === 'paid']);
});
