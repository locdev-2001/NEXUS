<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{   private $_data=[];
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
        $this->_data['media'] = Media::where('post_id',$post->id)->get();
        return response()->json([
            'd'=>$this->_data,
            's'=>'thanh cong'
        ]);
    }
}
