<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BankTransaction extends Model
{
    

    protected $fillable = [
        'order_id',
        'amount',
        'description',
        'ref_no',
        'status',
    ];

    // Quan hệ với đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
