<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable=['title','slug','status'];

    // public static function getProductByCountry($id){
    //     return Product::where('country_id',$id)->paginate(10);
    // }
    public function products(){
        return $this->hasMany('App\Models\Product','country_id','id')->where('status','active');
    }
    public static function getProductByCountry($slug){
        // dd($slug);
        return Country::with('products')->where('slug',$slug)->first();
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
}
