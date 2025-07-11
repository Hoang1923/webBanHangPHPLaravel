<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
class NotificationController extends Controller
{
    public function index(){
        return view('backend.notification.index');
    }
    public function show(Request $request){
        $notification=Auth()->user()->notifications()->where('id',$request->id)->first();
        if($notification){
            $notification->markAsRead();
            return redirect($notification->data['actionURL']);
        }
    }
    public function delete($id){
        $notification=Notification::find($id);
        if($notification){
            $status=$notification->delete();
            if($status){
                request()->session()->flash('success','Xóa thông báo thành công');
                return back();
            }
            else{
                request()->session()->flash('error','Có lỗi, vui lòng thử lại');
                return back();
            }
        }
        else{
            request()->session()->flash('error','Không tìm thấy thông báo');
            return back();
        }
    }
}
