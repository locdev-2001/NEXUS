<?php

namespace App\Http\Controllers\client;

use App\Events\ReactionPost;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Post_reactions;
use App\Models\Posts;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    //
    public function reaction(Request $request){
        $user_id = Auth::id();
        $user_name = Auth::user()->name;
        $post_id = $request->input('p_id');
        $reaction_type = $request->input('type');
        // tim nguoi dung dang bai viet
        $profile = Profile::where('user_id',$user_id)->first();
        $post = Posts::findOrFail($post_id);
        $recipient_id = $post->user_id;
        // kiểm tra người dùng này đã reaction bài viết này chưa
        $post_reaction= Post_reactions::where('user_id',$user_id)->where('post_id',$post_id)->first();
        if ($post_reaction){
            if ($post_reaction->reaction_type ==$reaction_type){
                $post_reaction->delete();
                Notification::where('sender_id',$user_id)->where('post_id',$post_id)->delete();
                return response()->json([
                    'error'=>'same',
                    'post_id'=>$post_id,
                ]);
            }
            else{
                $post_reaction->update(['reaction_type'=>$reaction_type]);
                switch ($reaction_type){
                    case 1 : $data = ['avatar'=>$profile->avatar,'senderId'=>$user_id,'message'=> $user_name.' đã thích bài viết của bạn','reaction_type'=>$reaction_type,'hyper_link'=>'/post?id='.$post_id]; break;
                    case 2 : $data = ['avatar'=>$profile->avatar,'senderId'=>$user_id,'message'=> $user_name.' đã yêu thích bài viết của bạn','reaction_type'=>$reaction_type,'hyper_link'=>'/post?id='.$post_id]; break;
                    case 3 : $data = ['avatar'=>$profile->avatar,'senderId'=>$user_id,'message'=>$user_name.' đã haha bài viết của bạn','reaction_type'=>$reaction_type,'hyper_link'=>'/post?id='.$post_id]; break;
                    case 4 : $data = ['avatar'=>$profile->avatar,'senderId'=>$user_id,'message'=>$user_name.' đã wow bài viết của bạn','reaction_type'=>$reaction_type,'hyper_link'=>'/post?id='.$post_id]; break;
                    case 5 : $data = ['avatar'=>$profile->avatar,'senderId'=>$user_id,'message'=>$user_name.' đã cảm thấy buồn bài viết của bạn','reaction_type'=>$reaction_type,'hyper_link'=>'/post?id='.$post_id]; break;
                    case 6 : $data = ['avatar'=>$profile->avatar,'senderId'=>$user_id,'message'=>$user_name.' đã phẫn nộ viết của bạn','reaction_type'=>$reaction_type,'hyper_link'=>'/post?id='.$post_id]; break;
                }
                Notification::where('sender_id',$user_id)->where('post_id',$post_id)->update(['data'=>$data]);
                return response()->json([
                   'post_id'=>$post_id,
                   'success'=>'Thanh cong'
                ]);
            }
        }
        else{
            switch ($reaction_type){
                case 1 : $data = ['avatar'=>$profile->avatar,'senderId'=>$user_id,'message'=> $user_name.' đã thích bài viết của bạn','reaction_type'=>$reaction_type,'hyper_link'=>'/post?id='.$post_id]; break;
                case 2 : $data = ['avatar'=>$profile->avatar,'senderId'=>$user_id,'message'=> $user_name.' đã yêu thích bài viết của bạn','reaction_type'=>$reaction_type,'hyper_link'=>'/post?id='.$post_id]; break;
                case 3 : $data = ['avatar'=>$profile->avatar,'senderId'=>$user_id,'message'=>$user_name.' đã haha bài viết của bạn','reaction_type'=>$reaction_type,'hyper_link'=>'/post?id='.$post_id]; break;
                case 4 : $data = ['avatar'=>$profile->avatar,'senderId'=>$user_id,'message'=>$user_name.' đã wow bài viết của bạn','reaction_type'=>$reaction_type,'hyper_link'=>'/post?id='.$post_id]; break;
                case 5 : $data = ['avatar'=>$profile->avatar,'senderId'=>$user_id,'message'=>$user_name.' đã cảm thấy buồn bài viết của bạn','reaction_type'=>$reaction_type,'hyper_link'=>'/post?id='.$post_id]; break;
                case 6 : $data = ['avatar'=>$profile->avatar,'senderId'=>$user_id,'message'=>$user_name.' đã phẫn nộ viết của bạn','reaction_type'=>$reaction_type,'hyper_link'=>'/post?id='.$post_id]; break;
            }
            Post_reactions::create([
                'user_id' => $user_id,
                'post_id'=> $post_id,
                'reaction_type'=>$reaction_type
            ]);
            event(new ReactionPost($user_id,$post_id,$reaction_type,$recipient_id,$data));
            return response()->json([
                'post_id'=> $post_id,
                'recipient'=>$recipient_id,
                'data'=>$data
            ]);
        }
    }
}
