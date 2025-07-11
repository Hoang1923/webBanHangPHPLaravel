<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Nếu Order của bạn nằm ở namespace khác thì sửa lại

class PaymentController extends Controller
{
    public function generateVietQR($orderId)
    {
        // Lấy thông tin đơn hàng (ví dụ: order_number, tổng tiền)
        $order = Order::findOrFail($orderId);

        // Thông tin nhận tiền
        $bankAccount = '9704181234567890';
        $accountName = 'CTY TNHH JELLY BOUTIQUE';

        // Số tiền và nội dung chuyển khoản
        $amount = $order->total_amount;
        $orderNumber = $order->order_number;
        $transferContent = "Thanh toan don hang {$orderNumber}";

        // Encode nội dung
        $transferContentEncoded = urlencode($transferContent);
        $accountNameEncoded = urlencode($accountName);

        // Tạo link QR VietQR
        $qrUrl = "https://img.vietqr.io/image/{$bankAccount}-compact2.png"
                . "?amount={$amount}"
                . "&addInfo={$transferContentEncoded}"
                . "&accountName={$accountNameEncoded}";

        // Gửi dữ liệu sang view
        return view('payment.vietqr', [
            'order' => $order,
            'qrUrl' => $qrUrl,
            'transferContent' => $transferContent
        ]);
    }
}
