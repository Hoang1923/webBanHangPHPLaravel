<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Nếu không có từ ngày và đến ngày (tức người dùng vừa load /admin thôi)
        if (!$request->has('from_date') && !$request->has('to_date')) {
            // Tự động redirect sang URL với query rỗng như yêu cầu
            return redirect()->route('user.dashboard', [
                'from_date' => '',
                'to_date' => '',
            ]);
        }

        // Sau đây là logic tính toán
        $categoryCount = \App\Models\Category::countActiveCategory($fromDate, $toDate);
        $productCount = \App\Models\Product::countActiveProduct($fromDate, $toDate);
        $orderCount = \App\Models\Order::countActiveOrder($fromDate, $toDate);
        $customerCount = \App\User::countActiveUser($fromDate, $toDate);
        $sumProduct = \App\Models\Product::sumActiveProduct($fromDate, $toDate);
        $newOrderCount = \App\Models\Order::countNewOrder($fromDate, $toDate);
        $totalRevenue = \App\Models\Cart::totalOfSales($fromDate, $toDate);
        $cancelOrderCount = \App\Models\Order::countCancelOrder($fromDate, $toDate);






        return view('user.index', compact('fromDate', 'toDate', 'categoryCount', 'cancelOrderCount', 'productCount',  'orderCount',  'customerCount',  'sumProduct',  'newOrderCount',  'totalRevenue'));
    }
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->paginate(10);
        return view('backend.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'string|required|max:30',
                'email' => 'string|required|unique:users',
                'password' => 'string|required',
                'role' => 'required|in:admin,user',
                'status' => 'required|in:active,inactive',
                'photo' => 'nullable|string',
            ]
        );
        // dd($request->all());
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        // dd($data);
        $status = User::create($data);
        // dd($status);
        if ($status) {
            request()->session()->flash('success', 'Thêm người dùng thành công');
        } else {
            request()->session()->flash('error', 'Có lỗi xảy ra khi thêm người dùng');
        }
        return redirect()->route('users.index');
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
        $user = User::findOrFail($id);
        return view('backend.users.edit')->with('user', $user);
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
    $user = User::findOrFail($id);

    // Validate dữ liệu đầu vào
    $request->validate([
        'name' => 'required|string|max:191',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|in:admin,user',
        'status' => 'required|in:active,inactive',
        'photo' => 'nullable|string',
    ]);

    // Cập nhật dữ liệu
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->role = $request->input('role');
    $user->status = $request->input('status');
    $user->photo = $request->input('photo');

    if ($user->save()) {
        return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công');
    } else {
        return back()->with('error', 'Có lỗi xảy ra khi cập nhật người dùng');
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = User::findorFail($id);
        $status = $delete->delete();
        if ($status) {
            request()->session()->flash('success', 'Xóa người dùng thành công');
        } else {
            request()->session()->flash('error', 'Có lỗi xảy ra khi xóa');
        }
        return redirect()->route('users.index');
    }
}
