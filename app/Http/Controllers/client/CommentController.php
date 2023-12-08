<?php

namespace App\Http\Controllers\client;

use App\Events\Comment;
use App\Events\ReactionComment;
use App\Http\Controllers\BaseClientController;
use App\Http\Controllers\Controller;
use App\Models\Comment_reaction;
use App\Models\Notification;
use App\Models\Post_comments;
use App\Models\Posts;
use App\Models\Profile;
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
        $post = Posts::findOrFail($post_id);
        $recipient_id = $post->user_id;
        $content = $request->input('content');
        $params['user_id'] = $user_id;
        $params['post_id'] = $post_id;
        $params['content'] = $content;
        $comment = Post_comments::create($params);
        $userName = Auth::user()->name;
        $avatar = Profile::where('user_id',Auth::id())->first()->avatar;
        $data = ['avatar'=>$avatar,'sender_id'=>$user_id,'post_id'=>$post_id,'message'=>$userName.' đã bình luận về bài viết của bạn','hyper_link'=>'/post?id='.$post_id.'#cmt-'.$comment->id];
        event( new Comment($recipient_id, $user_id, $data,$post_id, $comment->id));
        return response()->json([
            'comment'=>$comment,
            'userName'=>$userName,
            'avatar'=>$avatar,
            'atMoment'=>$this->getTimeAgoAtrr($comment->created_at)
        ]);
    }
    public function reply(Request $request){
        $user_id = Auth::id();
        $post_id = $request->input('post_id');
        $content = $request->input('content');
        $parent_id = $request->input('parent_id');
        $pr_comment = Post_comments::findOrFail($parent_id);
        $recipient_id = $pr_comment->user_id;
        $params['user_id'] = $user_id;
        $params['post_id'] = $post_id;
        $params['content'] = $content;
        $params['parent_id'] = $parent_id;
        $replyComment = Post_comments::create($params);
        $userName = Auth::user()->name;
        $avatar = Profile::where('user_id',Auth::id())->first()->avatar;
        $data = ['avatar'=>$avatar,'sender_id'=>$user_id,'post_id'=>$post_id,'message'=>$userName.' đã trả lời một bình luận của bạn','hyper_link'=>'/post?id='.$post_id.'#cmt-'.$replyComment->id];
        event( new Comment($recipient_id, $user_id, $data,$post_id, $replyComment->id));
        return response()->json([
            'replyComment'=>$replyComment,
            'userName'=>$userName,
            'atMoment'=>$this->getTimeAgoAtrr($replyComment->created_at)
        ]);
    }
    public function reaction(Request $request){
        $comment_id = $request->input('comment_id');
        $user_id = Auth::id();
        $post_id = $request->input('post_id');
        $comment = Post_comments::where('id',$comment_id)->first();
        $recipient_id = $comment->user_id;
        $params['comment_id'] = $comment_id;
        $params['user_id'] = $user_id;
        $params['post_id'] = $post_id;
        $profile = Profile::findOrFail($user_id)->first();
        $userName = Auth::user()->name;
        $data = [
            'avatar'=>$profile->avatar,
            'sender_id'=>$user_id,
            'post_id'=>$post_id,
            'comment_id'=>$comment_id,
            'message'=>$userName.' đã thích bình luận của bạn',
            'hyper_link'=>'/post?id='.$post_id.'#cmt-'.$comment_id,
        ];
        $comment_reaction = Comment_reaction::where('comment_id',$comment_id)->where('user_id',$user_id)->where('post_id',$post_id)->first();
        if($comment_reaction){
            $comment_reaction->delete();
            $existedNotification = Notification::where('data',json_encode($data))->delete();
            $count_reaction_on_comment = count(Comment_reaction::where('comment_id',$comment_id)->get());
            return response()->json([
                'error'=>'same',
                'count'=>$count_reaction_on_comment
            ]);
        }
        else{
            Comment_reaction::create($params);
            $count_reaction_on_comment = count(Comment_reaction::where('comment_id',$comment_id)->get());
            event(new ReactionComment($recipient_id,$user_id,$data,$comment_id,$post_id));
            return response()->json([
                'success'=>'thanh cong',
                'cmt-id'=>$comment_id,
                'comment'=>$comment,
                'recip'=>$recipient_id,
                'send'=>$user_id,
                'count'=>$count_reaction_on_comment
            ]);
        }
    }
}
