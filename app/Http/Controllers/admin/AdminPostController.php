<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Post_comments;
use App\Models\Post_reactions;
use App\Models\Posts;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    //
    public function index(){
        $posts = Posts::with('user')->get();
        return view('admin.post',compact('posts'));
    }
    public function delete($id){
        $post = Posts::findOrFail($id);
        $post->delete();
        $cmt = Post_comments::where('post_id',$post->id)->delete();
        $react = Post_reactions::where('post_id',$post->id)->delete();
        $media = Media::where('post_id',$post->id)->delete();
        return redirect('/admin/posts')->with('success', 'Xóa bài viết thành công');
    }
}
