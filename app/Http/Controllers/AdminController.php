<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\User;
use App\Rules\MatchOldPassword;
use Hash;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Nếu không có từ ngày và đến ngày
        if (!$request->has('from_date') && !$request->has('to_date')) {
            // Tự động redirect sang URL với query rỗng như yêu cầu
            return redirect()->route('admin.dashboard', [
                'from_date' => '',
                'to_date' => '',
            ]);
        }

        // logic tính toán
        $categoryCount = \App\Models\Category::countActiveCategory($fromDate, $toDate);
        $productCount = \App\Models\Product::countActiveProduct($fromDate, $toDate);
        $orderCount = \App\Models\Order::countActiveOrder($fromDate, $toDate);
        $customerCount = \App\User::countActiveUser($fromDate, $toDate);
        $sumProduct = \App\Models\Product::sumActiveProduct($fromDate, $toDate);
        $newOrderCount = \App\Models\Order::countNewOrder($fromDate, $toDate);
        $totalRevenue = \App\Models\Cart::totalOfSales($fromDate, $toDate);
        $cancelOrderCount = \App\Models\Order::countCancelOrder($fromDate, $toDate);






        return view('backend.index', compact('fromDate', 'toDate', 'categoryCount', 'cancelOrderCount', 'productCount',  'orderCount',  'customerCount',  'sumProduct',  'newOrderCount',  'totalRevenue'));
    }





    public function index()
    {
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDay(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
        //  return $data;
        return view('backend.index')->with('users', json_encode($array));
    }

    public function profile()
    {
        $profile = Auth()->user();
        // return $profile;
        return view('backend.users.profile')->with('profile', $profile);
    }

    public function profileUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048000',
            'role' => 'required|in:admin,user',
        ]);

        $data = $request->all();

        // Xử lý upload ảnh
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            // Tạo thư mục nếu chưa có
            $path = public_path('images');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Di chuyển file ảnh
            $file->move($path, $filename);

            // Gán đường dẫn để lưu vào DB
            $data['photo'] = 'images/' . $filename;
        } else {
            unset($data['photo']);
        }

        // Không cho sửa email
        $data['email'] = $user->email;

        $status = $user->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Cập nhật thông tin thành công');
        } else {
            request()->session()->flash('error', 'Có lỗi xảy ra, vui lòng thử lại');
        }

        return redirect()->back();
    }




    public function settings()
    {
        $data = Settings::first();
        return view('backend.setting')->with('data', $data);
    }

    public function settingsUpdate(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'short_des' => 'required|string',
            'description' => 'required|string',
            'photo' => 'required',
            'logo' => 'required',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);
        $data = $request->all();
        // return $data;
        $settings = Settings::first();
        // return $settings;
        $status = $settings->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Cập nhật cài đặt thành công');
        } else {
            request()->session()->flash('error', 'Vui lòng thử lại');
        }
        return redirect()->route('admin');
    }

    public function changePassword()
    {
        return view('backend.layouts.changePassword');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('admin')->with('success', 'thay đổi mật khẩu thành công');
    }

    // Pie chart
    public function userPieChart(Request $request)
    {
        // dd($request->all());
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDay(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
        //  return $data;
        return view('backend.index')->with('course', json_encode($array));
    }

    // public function activity(){
    //     return Activity::all();
    //     $activity= Activity::all();
    //     return view('backend.layouts.activity')->with('activities',$activity);
    // }
}
