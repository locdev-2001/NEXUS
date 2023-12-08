<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\BaseClientController;
use App\Models\Comment_reaction;
use App\Models\Friends;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends BaseClientController
{
    //
    protected $_data = [
        'title'=>'Trang chủ'
    ];
    public function index(){

        $posts = Posts::with(['media','reactions','user.profile','comments.user','comments.replies.user'])->where('active','1')->orderBy('created_at','desc')->get();
        $postsArr = $posts->map(function ($p){
//            dd($p->comments->toArray());
            $comments = $this->buildNestedComments($p->comments);
//            dd($comments);
            return [
                'id' => $p->id,
                'user_id' => $p->user_id,
                'user_name'=>$p->user->name,
                'user_avatar'=>$p->user->profile->avatar,
                'content_text' => $p->content_text,
                'post_mode'=>$p->post_mode,
                'media_dir' => $p->media->pluck('media_dir')->toArray(),
                'reactions'=>$p->reactions->toArray(),
                'comments'=>$comments,
                'reaction_comment'=>Comment_reaction::where('post_id',$p->id)->get(),
                'countComment'=>count($p->comments),
                'created_at'=> $this->getTimeAgoAtrr($p->created_at),
                'updated_at'=>$this->getTimeAgoAtrr($p->updated_at)
            ];
        });
//        dd($postsArr);
        $user_id = Auth::id();
        $friends = Friends::where(function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->orWhere(function ($query) use ($user_id) {
            $query->where('friend_id', $user_id);
        })->get();

        $friendIds = $friends->pluck('user_id')->merge($friends->pluck('friend_id'))->unique();

        $friendsWithNames = User::with('profile')->whereIn('id', $friendIds)->get(['id', 'name']);
        $this->_data['posts'] = $postsArr;
        $this->_data['friends'] = $friendsWithNames;

        return view('client.pages.index',$this->_data);
    }

}
