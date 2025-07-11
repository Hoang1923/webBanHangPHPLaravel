<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
      const PAYMENT_METHOD_COD = 'cod';
   
    const PAYMENT_METHOD_BANK_TRANSFER = 'bank_transfer';
    protected $fillable=['user_id','order_number','sub_total','quantity','delivery_charge','status','total_amount','first_name','last_name','country','post_code','address1','address2','phone','email','payment_method','payment_status','shipping_id','coupon'];

    public function cart_info(){
        return $this->hasMany('App\Models\Cart','order_id','id');
    }
    public static function getAllOrder($id){
        return Order::with('cart_info')->find($id);
    }
    public static function getPaymentMethods()
    {
        return [
            self::PAYMENT_METHOD_COD => 'Thanh toán khi nhận hàng',
           
            self::PAYMENT_METHOD_BANK_TRANSFER => 'Chuyển khoản ngân hàng',
        ];
    }

    public function bankTransactions()
{
    return $this->hasMany(BankTransaction::class);
}

    public function orderDetails()
{
    return $this->hasMany(OrderDetail::class);
}

  public static function countActiveOrder($fromDate = null, $toDate = null)
{
    $query = self::query();

    // Chỉ lọc ngày nếu có fromDate/toDate
    if ($fromDate) {
        $query->whereDate('created_at', '>=', $fromDate);
    }
    if ($toDate) {
        $query->whereDate('created_at', '<=', $toDate);
    }

    // Nếu không có điều kiện nào (tức cả 2 rỗng), query->count() sẽ lấy hết tất cả bản ghi
    return $query->count();
}


    public function cart(){
        return $this->hasMany(Cart::class);
    }

    public function shipping(){
        return $this->belongsTo(Shipping::class,'shipping_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public static function countNewOrder($fromDate = null, $toDate = null)
{
    $query = self::where('status', 'new');

    if ($fromDate) {
        $query->whereDate('created_at', '>=', $fromDate);
    }

    if ($toDate) {
        $query->whereDate('created_at', '<=', $toDate);
    }

    return $query->count();
}

   public static function countCancelOrder($fromDate = null, $toDate = null){
    $query = Order::where('status', 'cancel');

    if ($fromDate) {
        $query->whereDate('created_at', '>=', $fromDate);
    }
    if ($toDate) {
        $query->whereDate('created_at', '<=', $toDate);
    }

    return $query->count() ?: 0;
}



}
