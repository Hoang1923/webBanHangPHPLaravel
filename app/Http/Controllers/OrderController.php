<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;

use App\Models\Shipping;
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        return view('backend.order.index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Validate form
        $this->validate($request, [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'address1' => 'string|required',
            'address2' => 'string|nullable',
            'coupon' => 'nullable|numeric',
            'phone' => 'numeric|required',
            'post_code' => 'string|nullable',
            'email' => 'string|required'
        ]);

        // 2. Kiểm tra giỏ hàng
        $cartItems = Cart::where('user_id', auth()->user()->id)->whereNull('order_id')->get();
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // 3. Tính toán dữ liệu đơn hàng
        $order_data = $request->all();
        $order_data['order_number'] = 'ORD' . strtoupper(Str::random(10));
        $order_data['user_id'] = auth()->user()->id;
        $order_data['shipping_id'] = $request->shipping;
        $shipping_price = Shipping::where('id', $request->shipping)->value('price') ?? 0;

        $sub_total = Helper::totalCartPrice();
        $coupon_value = session('coupon')['value'] ?? 0;
        $total_amount = $sub_total + $shipping_price - $coupon_value;

        $order_data['sub_total'] = $sub_total;
        $order_data['quantity'] = Helper::cartCount();
        $order_data['coupon'] = $coupon_value;
        $order_data['total_amount'] = $total_amount;
        $order_data['status'] = 'new';

        // 4. Xử lý phương thức thanh toán
        $payment_method = $request->payment_method;
        if ($payment_method === 'bank_transfer') {
            $order_data['payment_method'] = 'bank_transfer';
            $order_data['payment_status'] = 'Unpaid';
        } else {
            $order_data['payment_method'] = 'cod';
            $order_data['payment_status'] = 'Unpaid';
        }

        // 5. Lưu đơn hàng
        $order = new Order();
        $order->fill($order_data);
        $order->save();

        // 6. Gửi thông báo cho admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Notification::send($admin, new StatusNotification([
                'title' => 'Có đơn hàng mới',
                'actionURL' => route('order.show', $order->id),
                'fas' => 'fa-file-alt'
            ]));
        }

        // 7. Lưu chi tiết đơn hàng
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        // 8. Cập nhật order_id cho các sản phẩm trong giỏ
        Cart::where('user_id', auth()->user()->id)->whereNull('order_id')->update(['order_id' => $order->id]);

        // 9. Xử lý redirect theo phương thức thanh toán
        session()->forget('cart');
        session()->forget('coupon');

        if ($payment_method === 'bank_transfer') {
            return redirect()->route('pages.vietqr', ['order' => $order->id]);
        }

        return redirect()->route('home')->with('success', 'Bạn đã đặt hàng thành công');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function handleWebhook(Request $request)
    {
        \Log::info('Webhook được gọi từ Casso.');
        \Log::info('Dữ liệu webhook: ' . json_encode($request->all()));

        $data = $request->input('data');

        // Nếu không có dữ liệu thì vẫn trả về 200 OK cho Casso test
        if (!$data || !isset($data['description']) || !isset($data['amount'])) {
            return response()->json(['message' => 'Webhook nhận OK (test)', 'status' => true], 200);
        }

        $description = $data['description'];
        $amount = $data['amount'];

        preg_match('/ORD[A-Z0-9]{10}/', $description, $matches);
        if (empty($matches)) {
            return response()->json(['message' => 'Không tìm thấy mã đơn hàng', 'status' => false], 200);
        }

        $order_number = $matches[0];

        $order = Order::where('order_number', $order_number)->first();
        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không tồn tại', 'status' => false], 200);
        }

        if ((int)$order->total_amount != (int)$amount) {
            \Log::warning("Số tiền không khớp cho đơn hàng {$order_number}. Dự kiến: {$order->total_amount}, nhận: {$amount}");
            return response()->json(['message' => 'Số tiền không khớp', 'status' => false], 200);
        }

        $order->payment_status = 'paid';
        $order->save();

        \Log::info("Đã cập nhật đơn hàng {$order_number} thành 'paid'.");

        return response()->json(['message' => 'Cập nhật thành công', 'status' => true], 200);
    }


    public function checkPaymentStatus($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['paid' => false]);
        }

        return response()->json([
            'paid' => $order->payment_status === 'paid',
        ]);
    }


    public function showVietQR(Order $order)
    {
        // Cấu hình thông tin người nhận chuyển khoản
        $accountName = 'DANG VAN HOANG';
        $accountNumber = '108874780496';
        $bankCode = 'ICB'; // Vietcombank
        $amount = $order->total_amount;
        $description =  $order->order_number;

        // Tạo URL đến VietQR API
        $qrUrl = "https://img.vietqr.io/image/{$bankCode}-{$accountNumber}-compact2.jpg";
        $qrUrl .= "?amount={$amount}&addInfo=" . urlencode($description) . "&accountName=" . urlencode($accountName);

        return view('frontend.pages.vietqr', compact('order', 'qrUrl', 'accountName', 'accountNumber', 'amount', 'description'));
    }


    public function show($id)
    {
        $order = Order::with('orderDetails.product')->findOrFail($id);
        return view('backend.order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return view('backend.order.edit')->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $this->validate($request, [
            'status' => 'required|in:new,process,delivered,cancel'
        ]);
        $data = $request->only(['status']);
        // return $request->status;
        if ($request->status == 'delivered') {
            foreach ($order->cart as $cart) {
                $product = $cart->product;
                // return $product;
                $product->stock -= $cart->quantity;
                $product->save();
            }
            if ($order->payment_method === 'cod' && $order->payment_status === 'unpaid') {
                $data['payment_status'] = 'paid';
            }
            
        }
        $status = $order->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Cập nhật đơn hàng thành công');
        } else {
            request()->session()->flash('error', 'Có lỗi khi cập nhật đơn hàng');
        }
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $status = $order->delete();
            if ($status) {
                request()->session()->flash('success', 'Xóa đơn hàng thành công');
            } else {
                request()->session()->flash('error', 'Đơn hàng không thể xóa');
            }
            return redirect()->route('order.index');
        } else {
            request()->session()->flash('error', 'Không tìm thấy đơn hàng');
            return redirect()->back();
        }
    }

    public function orderTrack()
    {
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request)
    {
        // return $request->all();
        $order = Order::where('user_id', auth()->user()->id)->where('order_number', $request->order_number)->first();
        if ($order) {
            if ($order->status == "new") {
                request()->session()->flash('success', 'Đơn hàng của bạn đã được đặt. Vui lòng chờ.');
                return redirect()->route('order.track');
            } elseif ($order->status == "process") {
                request()->session()->flash('success', 'Đơn hàng của bạn đang được xử lý. Vui lòng chờ.');
                return redirect()->route('order.track');
            } elseif ($order->status == "delivered") {
                request()->session()->flash('success', 'Đơn hàng của bạn đã được giao. Xin chân thành cảm ơn.');
                return redirect()->route('order.track');
            } else {
                request()->session()->flash('error', 'Đơn hàng của bạn đã bị hủy, vui lòng thử lại.');
                return redirect()->route('order.track');
            }
        } else {
            request()->session()->flash('error', 'Mã đơn hàng không hợp lệ, vui lòng thử lại.');
            return back();
        }
    }

    // PDF generate
    public function pdf(Request $request)
    {
        $order = Order::getAllOrder($request->id);
        // return $order;
        $file_name = $order->order_number . '-' . $order->first_name . '.pdf';
        // return $file_name;
        $pdf = PDF::loadview('backend.order.pdf', compact('order'));
        return $pdf->download($file_name);
    }
    // Income chart
    public function incomeChart(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;
        // dd($year);
        $items = Order::with(['cart_info'])->whereYear('created_at', $year)->where('status', 'delivered')->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
        // dd($items);
        $result = [];
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount = $item->cart_info->sum('amount');
                // dd($amount);
                $m = intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }

    // Income chart quarterly
    public function incomeChartQuarterly(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;
        $quarter = \Carbon\Carbon::quartersUntil($endDate = null, $factor = 1);
        // dd($year);
        $items = Order::with(['cart_info'])->whereMonth('created_at', $quarter)->where('status', 'delivered')->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
        // dd($items);
        $result = [];
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount = $item->cart_info->sum('amount');
                // dd($amount);
                $m = intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }
        $data = [];
        for ($i = 1; $i <= 4; $i++) {
            $monthName = date('n', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
