<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Expiry;
use App\Models\Unit;

use App\Models\Country;
use Intervention\Image\Facades\Image;


use Illuminate\Support\Str;

class ProductController extends Controller
{


    public function expiry()
    {
        $products = Product::with(['cat_info', 'sub_cat_info', 'expiry'])->get()->filter(function ($product) {
            if (empty($product->year_of_manufacture) || empty($product->expiry)) {
                return false;
            }

            if (preg_match('/(\d+)/', $product->expiry->title, $matches)) {
                $months = (int) $matches[1];
                $manufactureDate = \Carbon\Carbon::parse($product->year_of_manufacture);
                $expiryDate = $manufactureDate->copy()->addMonths($months);
                // return \Carbon\Carbon::today()->gte($expiryDate->copy()->addMonths(10));
                return \Carbon\Carbon::today()->gte($expiryDate);

            }

            return false;
        });

        // Phân trang thủ công:
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $products->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($currentItems, $products->count(), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('backend.product.expiry', ['products' => $paginated]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::getAllProduct();
        // return $products;
        return view('backend.product.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //      $countries = Country::all();
    //     $brand=Brand::get();
    //     $category=Category::where('is_parent',1)->get();
    //     // return $category;
    //     return view('backend.product.create', compact('countries'))->with('categories',$category)->with('brands',$brand);
    // }
    public function create()
    {
        $countries = Country::all();
        $brand = Brand::get();
        $category = Category::where('is_parent', 1)->get();
        $expiries = Expiry::where('status', 'active')->get();
        $units = Unit::all();

        return view('backend.product.create', compact('countries', 'units'))
            ->with('categories', $category)
            ->with('brands', $brand)
            ->with('expiries', $expiries);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048000',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'country_id' => 'nullable|exists:countries,id',
            'year_of_manufacture' => 'nullable|date',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric'
        ]);

        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        $data['is_featured'] = $request->input('is_featured', 0);
        $data['year_of_manufacture'] = $request->input('year_of_manufacture');
        $size = $request->input('size');
        if ($size) {
            $data['size'] = implode(',', $size);
        } else {
            $data['size'] = '';
        }
        // return $size;
        // return $data;
        //         if ($request->hasFile('photo')) {
        //     $imageName = time().'.'.$request->photo->extension();
        //     $request->photo->move(public_path('images'), $imageName);
        //     $data['photo'] = 'images/' . $imageName;
        // }
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('images');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Resize ảnh với chiều rộng 500px, giữ tỉ lệ, không phóng to ảnh nhỏ
            $img = Image::make($file->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save($path . '/' . $filename);

            $data['photo'] = 'images/' . $filename;
        }

        $status = Product::create($data);
        if ($status) {
            request()->session()->flash('success', 'Thêm sản phâm thành công');
        } else {
            request()->session()->flash('error', 'Vui lòng thử lại!!');
        }
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::get();
        $product = Product::findOrFail($id);
        $category = Category::where('is_parent', 1)->get();
        $items = Product::where('id', $id)->get();

        $countries = Country::all();
        $expiries = Expiry::all();
        $units = Unit::all();

        return view('backend.product.edit')
            ->with('product', $product)
            ->with('brands', $brand)
            ->with('categories', $category)
            ->with('items', $items)
            ->with('countries', $countries)
            ->with('expiries', $expiries)
            ->with('units', $units);
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
        $product = Product::findOrFail($id);

        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048000', // cho phép null
            'size' => 'nullable',
            'stock' => 'required|numeric',
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric'
        ]);

        $data = $request->all();
         $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        $data['is_featured'] = $request->input('is_featured', 0);
        $data['year_of_manufacture'] = $request->input('year_of_manufacture');

        $size = $request->input('size');
        $data['size'] = $size ? implode(',', $size) : '';

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('images');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file->move($path, $filename);
            $data['photo'] = 'images/' . $filename;
        } else {
            // Không thay đổi ảnh, bỏ key photo khỏi $data để giữ ảnh cũ
            unset($data['photo']);
        }

        $status = $product->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Cập nhật sản phẩm thành công');
        } else {
            request()->session()->flash('error', 'Vui lòng thử lại!!');
        }

        return redirect()->route('product.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $product=Product::findOrFail($id);
    //     $status=$product->delete();

    //     if($status){
    //         request()->session()->flash('success','Xóa sản phẩm thành công');
    //     }
    //     else{
    //         request()->session()->flash('error','Có lỗi trong quá trình xóa sản phẩm');
    //     }
    //     return redirect()->route('product.index');
    // }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Xóa file ảnh nếu có
        if ($product->photo) {
            $image_path = public_path($product->photo); // ví dụ 'images/abc.jpg'
            if (file_exists($image_path)) {
                unlink($image_path); // xóa file ảnh
            }
        }

        $status = $product->delete();

        if ($status) {
            request()->session()->flash('success', 'Xóa sản phẩm thành công');
        } else {
            request()->session()->flash('error', 'Có lỗi trong quá trình xóa sản phẩm');
        }
        return redirect()->route('product.index');
    }
}
