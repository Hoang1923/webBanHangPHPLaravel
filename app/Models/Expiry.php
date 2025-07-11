<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Expiry extends Model
{
    protected $table = 'expiry';
    protected $fillable=['title','slug','status'];

    // public static function getProductByExpiry($id){
    //     return Product::where('Expiry_id',$id)->paginate(10);
    // }
    public function products(){
        return $this->hasMany('App\Models\Product','expiry_id','id')->where('status','active');
    }
    public static function getProductByExpiry($slug){
        // dd($slug);
        return Expiry::with('products')->where('slug',$slug)->first();
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
}
