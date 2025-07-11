<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable=['user_id','product_id','order_id','quantity','amount','price','status'];

    // public function product(){
    //     return $this->hasOne('App\Models\Product','id','product_id');
    // }
    // public static function getAllProductFromCart(){
    //     return Cart::with('product')->where('user_id',auth()->user()->id)->get();
    // }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }

public static function totalOfSales($fromDate = null, $toDate = null)
{
    $query = self::query();

    if ($fromDate !== null && $fromDate !== '') {
        $query->whereDate('created_at', '>=', $fromDate);
    }
    if ($toDate !== null && $toDate !== '') {
        $query->whereDate('created_at', '<=', $toDate);
    }

    $total = $query->sum('amount');

    return $total ?: 0;
}



}
