<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\BaseClientController;
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

        $posts = Posts::with(['media','reactions','user','comments.user','comments.replies.user'])->orderBy('created_at','desc')->get();

        $postsArr = $posts->map(function ($p){
//            dd($p->comments->toArray());
            $comments = $this->buildNestedComments($p->comments);
            return [
                'id' => $p->id,
                'user_id' => $p->user_id,
                'user_name'=>$p->user->name,
                'content_text' => $p->content_text,
                'media_dir' => $p->media->pluck('media_dir')->toArray(),
                'reactions'=>$p->reactions->toArray(),
                'comments'=>$comments,
                'created_at'=> $this->getTimeAgoAtrr($p->created_at),
                'updated_at'=>$this->getTimeAgoAtrr($p->updated_at)
            ];
        });
        dd($postsArr);
        $this->_data['posts'] = $postsArr;
        return view('client.pages.index',$this->_data);
    }

}
