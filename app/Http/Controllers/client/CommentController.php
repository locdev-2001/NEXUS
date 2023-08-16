<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\BaseClientController;
use App\Http\Controllers\Controller;
use App\Models\Post_comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends BaseClientController
{
    //
    protected $_data = [

    ];
    public function create(Request $request){
        $user_id = Auth::id();
        $post_id = $request->input('post_id');
        $content = $request->input('content');
        $params['user_id'] = $user_id;
        $params['post_id'] = $post_id;
        $params['content'] = $content;
        $comment = Post_comments::create($params);
        $userName = Auth::user()->name;
        return response()->json([
            'comment'=>$comment,
            'userName'=>$userName,
            'atMoment'=>$this->getTimeAgoAtrr($comment->created_at)
        ]);
    }
    public function reply(Request $request){
        $user_id = Auth::id();
        $post_id = $request->input('post_id');
        $content = $request->input('content');
        $parent_id = $request->input('parent_id');
        $params['user_id'] = $user_id;
        $params['post_id'] = $post_id;
        $params['content'] = $content;
        $params['parent_id'] = $parent_id;
        $replyComment = Post_comments::create($params);
        $userName = Auth::user()->name;
        return response()->json([
            'replyComment'=>$replyComment,
            'userName'=>$userName,
            'atMoment'=>$this->getTimeAgoAtrr($replyComment->created_at)
        ]);
    }
}
