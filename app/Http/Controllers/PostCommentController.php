<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Notification;
use App\User;
use App\Notifications\StatusNotification;
use App\Models\PostComment;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = PostComment::getAllComments();
        return view('backend.comment.index')->with('comments', $comments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
{
    $post_info = Post::getPostBySlug($slug);

    if (!$post_info) {
        return redirect()->back()->with('error', 'Bài viết không tồn tại');
    }

    $data = $request->only(['comment']);
    $data['user_id'] = $request->user()->id;
    $data['post_id'] = $post_info->id;
    $data['status'] = 'active';

    PostComment::create($data);

    Notification::send(User::where('role', 'admin')->get(), new StatusNotification([
        'title' => "Bình luận mới được tạo",
        'actionURL' => route('blog.detail', $post_info->slug),
        'fas' => 'fas fa-comment'
    ]));

    return redirect()->route('blog.detail', $post_info->slug)
                     ->with('success', 'Cảm ơn bạn đã bình luận');
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
        $comments = PostComment::find($id);
        if ($comments) {
            return view('backend.comment.edit')->with('comment', $comments);
        } else {
            request()->session()->flash('error', 'Bình luận không tồn tại');
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
    public function update(Request $request, $id)
    {
        $comment = PostComment::find($id);
        if ($comment) {
            $data = $request->all();
            // return $data;
            $status = $comment->fill($data)->update();
            if ($status) {
                request()->session()->flash('success', 'Cập nhật bình luận thành công');
            } else {
                request()->session()->flash('error', 'Có lỗi xảy ra, vui lòng thử lại!!');
            }
            return redirect()->route('comment.index');
        } else {
            request()->session()->flash('error', 'Bình luận không tồn tại');
            return redirect()->back();
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
        $comment = PostComment::find($id);
        if ($comment) {
            $status = $comment->delete();
            if ($status) {
                request()->session()->flash('success', 'Bình luận xóa thành công');
            } else {
                request()->session()->flash('error', 'Có lỗi xảy ra, vui lòng thử lại');
            }
            return back();
        } else {
            request()->session()->flash('error', 'Bình luận bài viết không tồn tại');
            return redirect()->back();
        }
    }
}
