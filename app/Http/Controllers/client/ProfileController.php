<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\BaseClientController;
use App\Http\Controllers\Controller;
use App\Models\Comment_reaction;
use App\Models\Friends;
use App\Models\Media;
use App\Models\Posts;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends BaseClientController
{
    //
    protected $_data=[];
    public function index(Request $request){
        $user_id = $request->query('id');
        $user = User::where('id',$user_id)->first();
        $profile = Profile::where('user_id',$user_id)->first();

        // tìm những người mình là bạn của họ hoặc họ là bạn của mình
        $friends = Friends::where(function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->orWhere(function ($query) use ($user_id) {
            $query->where('friend_id', $user_id);
        })->get();

        $friendIds = $friends->pluck('user_id')->merge($friends->pluck('friend_id'))->unique();

        $friendsWithNames = User::with('profile')->whereIn('id', $friendIds)->get(['id', 'name']);
//        dd(count($friends));
        $posts = Posts::with(['media','reactions','user','comments.user','comments.replies.user'])->where('user_id',$user_id)->orderBy('created_at','desc')->get();
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
                'reaction_comment'=>Comment_reaction::where('post_id',$p->id)->get(),
                'countComment'=>count($p->comments),
                'created_at'=> $this->getTimeAgoAtrr($p->created_at),
                'updated_at'=>$this->getTimeAgoAtrr($p->updated_at)
            ];
        });
        $media = Media::where('user_id',$user_id)->pluck('media_dir')->toArray();
        $this->_data['posts'] = $postsArr;

        $this->_data['user'] =$user;
        $this->_data['profile']=$profile;
        $this->_data['media']=$media;
        $this->_data['friends']=$friendsWithNames;
        return view('client.pages.profile',$this->_data);
    }
    public function searchAjax(Request $request){
        $currentUserId = Auth::id();
        $keyword = $request->input('keyword');
        $users = User::with('profile')->where('name','like','%'.$keyword.'%')->where('id', '!=', $currentUserId)->get();
        return response()->json([
            'data'=>$users
        ]);
    }
    public function saveAvatar(Request $request){
        $src64 = $request->input('base64data');
        $user = Auth::user();
        $profile = Profile::where('user_id',$user->id)->first();
        if ($src64){
            $src64_arr = explode(";",$src64);
            $src64_arr2 = explode(",",$src64_arr[1]);
            $src = base64_decode($src64_arr2[1]);
            $currentDay = now()->format('Y-m-d');
            $folderPath = 'public/uploads/avatar/'.Auth::id().'/'.$currentDay;
            $extension = $this->f_info_buffer($src);
            $name = uniqid().'.'.$extension;
            Storage::put($folderPath.'/'.$name,$src);
            $filePath = Storage::url($folderPath . '/' . $name);
            $profile->avatar = $filePath;
            $profile->save();
            return response()->json([
                'success'=>'success'
            ]);
        }
    }
    public function saveCover(Request $request){
        $data = $request->input('data');
        $user_id = Auth::id();
        $profile = Profile::where('user_id',$user_id)->first();
        if($data){
            $data_arr = explode(";",$data);
            $data_arr2 = explode(",",$data_arr[1]);
            $src = base64_decode($data_arr2[1]);
            $currentDay = now()->format('Y-m-d');
            $folderPath = 'public/uploads/cover/'.Auth::id().'/'.$currentDay;
            $extension = $this->f_info_buffer($src);
            $name = uniqid().'.'.$extension;
            Storage::put($folderPath.'/'.$name,$src);
            $filePath = Storage::url($folderPath . '/' . $name);
            $profile->cover = $filePath;
            $profile->save();
            return response()->json([
                'success'=>'success',
                '$filePath'=>$filePath
            ]);
        }
    }
    public function saveBio(Request $request){
        $bio = $request->input('data');
        $user_id = Auth::id();
        $profile = Profile::where('user_id',$user_id)->first();
        if ($bio !== null){
            $profile->bio = $bio;
            $profile->save();
            return response()->json([
                'success'=>'success',
            ]);
        }
    }
}
