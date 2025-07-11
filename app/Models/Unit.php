<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';
    protected $fillable=['title','slug','status'];

    // public static function getProductByunit($id){
    //     return Product::where('unit_id',$id)->paginate(10);
    // }
    public function products(){
        return $this->hasMany('App\Models\Product','unit_id','id')->where('status','active');
    }
    public static function getProductByUnit($slug){
        // dd($slug);
        return Unit::with('products')->where('slug',$slug)->first();
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
}
