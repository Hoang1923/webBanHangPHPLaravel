<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use Carbon\Carbon;
class Product extends Model
{
    protected $fillable=['title','slug','summary','description','cat_id','child_cat_id','price','brand_id','unit_id','expiry_id','year_of_manufacture','country_id','discount','status','photo','stock','is_featured','condition'];

    public function cat_info(){
        return $this->hasOne('App\Models\Category','id','cat_id');
    }
    public function sub_cat_info(){
        return $this->hasOne('App\Models\Category','id','child_cat_id');
    }
    // public static function getAllProduct(){
    //     return Product::with(['cat_info','sub_cat_info'])->orderBy('id','desc')->paginate(10);
    // }



public static function getAllProduct()
{
    // Lấy toàn bộ sản phẩm cùng bảng expiry
    $products = Product::with(['expiry'])->get();

    foreach ($products as $product) {
        // Bỏ qua nếu thiếu ngày sản xuất hoặc không có liên kết expiry
        if (empty($product->year_of_manufacture) || empty($product->expiry)) {
            continue;
        }

        // Lấy số tháng từ title 
        if (preg_match('/(\d+)/', $product->expiry->title, $matches)) {
            $months = (int) $matches[1];

            $manufactureDate = Carbon::parse($product->year_of_manufacture);
            $expiryDate = $manufactureDate->copy()->addMonths($months);

            // Nếu hết hạn và đang còn "active"
            if (Carbon::today()->gte($expiryDate) && $product->status === 'active') {
                $product->status = 'inactive';
                $product->save();

            }
        }
    }

    // Trả về danh sách sản phẩm còn hạn dùng (status = active)
    return Product::with(['cat_info', 'sub_cat_info'])
        ->where('status', 'active')
        ->orderBy('id', 'desc')
        ->paginate(10);
}

    public function rel_prods(){
        return $this->hasMany('App\Models\Product','cat_id','cat_id')->where('status','active')->orderBy('id','DESC')->limit(8);
    }
    public function getReview(){
        return $this->hasMany('App\Models\ProductReview','product_id','id')->with('user_info')->where('status','active')->orderBy('id','DESC');
    }
    public static function getProductBySlug($slug){
        return Product::with(['cat_info','rel_prods','getReview'])->where('slug',$slug)->first();
    }
  public static function countActiveProduct($fromDate = null, $toDate = null)
{
    $query = self::where('status', 'active'); // Giả sử trạng thái 'active' là sản phẩm đang bán

    if ($fromDate) {
        $query->whereDate('created_at', '>=', $fromDate);
    }

    if ($toDate) {
        $query->whereDate('created_at', '<=', $toDate);
    }

    return $query->count();
}


    public function carts(){
        return $this->hasMany(Cart::class)->whereNotNull('order_id');
    }

    public function wishlists(){
        return $this->hasMany(Wishlist::class)->whereNotNull('cart_id');
    }

    public function brand(){
        return $this->hasOne(Brand::class,'id','brand_id');
    }
   public function expiry(){
    return $this->belongsTo(Expiry::class, 'expiry_id', 'id');
}

    public function unit(){
    return $this->belongsTo(Unit::class, 'unit_id', 'id');
}


    
   public function country(){
    return $this->belongsTo(Country::class, 'country_id', 'id');
}


 public static function sumActiveProduct($fromDate = null, $toDate = null)
{
    $query = Product::where('status', 'active');

    if ($fromDate) {
        $query->whereDate('created_at', '>=', $fromDate);
    }
    if ($toDate) {
        $query->whereDate('created_at', '<=', $toDate);
    }

    $data = $query->sum('stock');

    return $data ?: 0;
}


}
