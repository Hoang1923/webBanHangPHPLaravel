<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Str;

use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner = Banner::orderBy('id', 'DESC')->paginate(10);
        return view('backend.banner.index')->with('banners', $banner);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banner.create');
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
            'title' => 'string|required|max:50',
            'description' => 'string|nullable',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048000',
            'status' => 'required|in:active,inactive',
        ]);
        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Banner::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        // return $slug;

        if ($request->hasFile('photo')) {


            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('images');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Resize ảnh với chiều rộng 500px, giữ tỉ lệ, không phóng to ảnh nhỏ
            $img = Image::make($file->getRealPath());
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save($path . '/' . $filename);

            $data['photo'] = 'images/' . $filename;
        }
        $status = Banner::create($data);
        if ($status) {
            request()->session()->flash('success', 'Thêm Banner thành công');
        } else {
            request()->session()->flash('error', 'Có lỗi xảy ra trong quá trình thêm Banner');
        }
        return redirect()->route('banner.index');
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
        $banner = Banner::findOrFail($id);
        return view('backend.banner.edit')->with('banner', $banner);
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
        $banner = Banner::findOrFail($id);

        // Validate cơ bản
        $rules = [
            'title' => 'required|string|max:50',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ];

        // Chỉ validate ảnh nếu có file
        if ($request->hasFile('photo')) {
            $rules['photo'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048000';
        }

        $this->validate($request, $rules);

        $data = $request->all();

        // Nếu có ảnh mới
        if ($request->hasFile('photo')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($banner->photo && file_exists(public_path($banner->photo))) {
                unlink(public_path($banner->photo));
            }

            $file = $request->file('photo');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = time() . '.' . $extension;
            $path = public_path('images');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $img = Image::make($file->getRealPath());
            if ($img->width() > 1200) {
                $img->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            $quality = in_array($extension, ['jpg', 'jpeg']) ? 100 : 0;
            $img->save($path . '/' . $filename, $quality);

            $data['photo'] = 'images/' . $filename;
        } else {
            $data['photo'] = $banner->photo;
        }


        $status = $banner->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Banner cập nhật thành công');
        } else {
            request()->session()->flash('error', 'Có lỗi trong quá trình cập nhật Banner');
        }

        return redirect()->route('banner.index');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        // Xóa ảnh trong thư mục public/images nếu tồn tại
        if ($banner->photo && file_exists(public_path($banner->photo))) {
            unlink(public_path($banner->photo));
        }

        $status = $banner->delete();

        if ($status) {
            request()->session()->flash('success', 'Xóa Banner thành công');
        } else {
            request()->session()->flash('error', 'Có lỗi xảy ra trong quá trình xóa Banner');
        }

        return redirect()->route('banner.index');
    }
}
