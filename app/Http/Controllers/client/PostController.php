<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\BaseClientController;
use App\Http\Controllers\Controller;
use App\Models\Comment_reaction;
use App\Models\Media;
use App\Models\Post_comments;
use App\Models\Post_reactions;
use App\Models\Posts;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends BaseClientController
{   private $_data=[];
    public function index(Request $request){
        $id = $request->input('id');
        $post = Posts::with(['media','reactions','user.profile','comments.user','comments.replies.user'])->findOrFail($id);
        $comments = $this->buildNestedComments($post->comments);
        $this->_data['post']= (object)[
                'id' => $id,
                'user_id' => $post->user_id,
                'user_name'=>$post->user->name,
                'user_avatar'=>$post->user->profile->avatar,
                'content_text' => $post->content_text,
                'media_dir' => $post->media->pluck('media_dir')->toArray(),
                'reactions'=>$post->reactions->toArray(),
                'comments'=>$comments,
                'reaction_comment'=>Comment_reaction::where('post_id',$post->id)->get(),
                'countComment'=>count($post->comments),
                'created_at'=> $this->getTimeAgoAtrr($post->created_at),
                'updated_at'=>$this->getTimeAgoAtrr($post->updated_at)
            ];
        return view('client.pages.post',$this->_data);
    }
    public function createPost(Request $request){

        $params['user_id'] = Auth::id();
        $params['content_text'] = $request->content_text;
        $params['post_mode'] = $request->post_mode;
        $post = Posts::create($params);


        foreach ($request->input('document', []) as $file) {
            $prs['user_id'] = Auth::id();
            $prs['post_id'] = $post->id;
            $prs['media_dir']=$file;
            Media::create($prs);
        }
        $this->_data['post']=$post;
        $this->_data['post_user_name'] = User::findOrFail($post->user_id)->name;
        $profile = Profile::where('user_id',$post->user_id)->first();
        $this->_data['post_user_avatar'] =$profile->avatar;
        $this->_data['media'] = Media::where('post_id',$post->id)->get();
        return response()->json([
            'd'=>$this->_data,
            's'=>'thanh cong'
        ]);
    }
    public function edit(Request $request){
        $p_id = $request->input('p_id');
        $content = $request->input('content');
        $post_mode = $request->input('post_mode');
        $arrImgUpdate = $request->input('arrImgUpdate');
        $post = Posts::findOrFail($p_id);
        $post->content_text = $content;
        $post->post_mode = $post_mode;
        $post->save();
        $mediaToDelete = Media::whereIn('media_dir', $arrImgUpdate)->where('post_id', $p_id)->get();
        foreach ($mediaToDelete as $media) {
            // Xóa tệp vật lý trước khi xóa cơ sở dữ liệu
            Storage::delete($media->media_dir);
            $media->delete();
        }
        return response()->json([
           'success'=>'Thành công'
        ]);
    }
    public function delete(Request $request){
        $p_id = $request->input('p_id');
        Posts::findOrFail($p_id)->delete();
        Post_comments::where('post_id',$p_id)->delete();
        Post_reactions::where('post_id',$p_id)->delete();
        Media::where('post_id',$p_id)->delete();
        Comment_reaction::where('post_id',$p_id)->delete();
        return response()->json([
           'success'=>'Xóa thành công'
        ]);
    }
}
