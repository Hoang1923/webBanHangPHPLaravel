<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\PostComment;
use App\Rules\MatchOldPassword;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index(){
        return view('user.index');
    }

    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('user.users.profile')->with('profile',$profile);
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

    // Order
    public function orderIndex(){
        $orders=Order::orderBy('id','DESC')->where('user_id',auth()->user()->id)->paginate(10);
        return view('user.order.index')->with('orders',$orders);
    }
    public function userOrderDelete($id)
    {
        $order=Order::find($id);
        if($order){
           if($order->status=="process" || $order->status=='delivered' || $order->status=='cancel'){
                return redirect()->back()->with('error','Bạn không thể xóa đơn hàng này bây giờ');
           }
           else{
                $status=$order->delete();
                if($status){
                    request()->session()->flash('success','Xóa đơn hàng thành công');
                }
                else{
                    request()->session()->flash('error','Không thể xóa đơn hàng này');
                }
                return redirect()->route('user.order.index');
           }
        }
        else{
            request()->session()->flash('error','Đơn hàng không tồn tại');
            return redirect()->back();
        }
    }

    public function orderShow($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('user.order.show')->with('order',$order);
    }
    // Product Review
    public function productReviewIndex(){
        $reviews=ProductReview::getAllUserReview();
        return view('user.review.index')->with('reviews',$reviews);
    }

    public function productReviewEdit($id)
    {
        $review=ProductReview::find($id);
        // return $review;
        return view('user.review.edit')->with('review',$review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewUpdate(Request $request, $id)
    {
        $review=ProductReview::find($id);
        if($review){
            $data=$request->all();
            $status=$review->fill($data)->update();
            if($status){
                request()->session()->flash('success','Cập nhật đánh giá thành công');
            }
            else{
                request()->session()->flash('error','Có lỗi xảy ra! Vui lòng thử lại!!');
            }
        }
        else{
            request()->session()->flash('error','Đánh giá không tồn tại!!');
        }

        return redirect()->route('user.productreview.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewDelete($id)
    {
        $review=ProductReview::find($id);
        $status=$review->delete();
        if($status){
            request()->session()->flash('success','Xóa đánh giá thành công');
        }
        else{
            request()->session()->flash('error','Có lỗi xảy ra! Vui lòng thử lại');
        }
        return redirect()->route('user.productreview.index');
    }

    public function userComment()
    {
        $comments=PostComment::getAllUserComments();
        return view('user.comment.index')->with('comments',$comments);
    }
    public function userCommentDelete($id){
        $comment=PostComment::find($id);
        if($comment){
            $status=$comment->delete();
            if($status){
                request()->session()->flash('success','Bình luận bài viết xóa thành công');
            }
            else{
                request()->session()->flash('error','Có lỗi xảy ra, vui lòng thử lại');
            }
            return back();
        }
        else{
            request()->session()->flash('error','Bình luận bài viết không tồn tại');
            return redirect()->back();
        }
    }
    public function userCommentEdit($id)
    {
        $comments=PostComment::find($id);
        if($comments){
            return view('user.comment.edit')->with('comment',$comments);
        }
        else{
            request()->session()->flash('error','Bình luận không tồn tại');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userCommentUpdate(Request $request, $id)
    {
        $comment=PostComment::find($id);
        if($comment){
            $data=$request->all();
            // return $data;
            $status=$comment->fill($data)->update();
            if($status){
                request()->session()->flash('success','Cập nhật bình luận thành công');
            }
            else{
                request()->session()->flash('error','Có lỗi xảy ra! Vui lòng thử lại!!');
            }
            return redirect()->route('user.post-comment.index');
        }
        else{
            request()->session()->flash('error','Bình luận không tồn tại');
            return redirect()->back();
        }

    }

    public function changePassword(){
        return view('user.layouts.userPasswordChange');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->route('user')->with('success','Đổi mật khẩu thành công');
    }


}
