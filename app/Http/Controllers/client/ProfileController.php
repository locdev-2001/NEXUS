<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Friends;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    protected $_data=[];
    public function index(Request $request){
        $user_id = $request->query('id');
        $user = User::where('id',$user_id)->first();
        $profile = Profile::where('user_id',$user_id)->first();

        // tìm những người mình là bạn của họ hoặc họ là bạn của mình
        $friends = Friends::where(function ($query) use($user_id){
            $query->where('user_id',$user_id);
        })->orWhere(function ($query) use ($user_id){
            $query->where('friend_id',$user_id);
        })->get();
//        dd(count($friends));
        $this->_data['user'] =$user;
        $this->_data['profile']=$profile;
        $this->_data['friends']=$friends;
        return view('client.pages.profile',$this->_data);
    }
    public function searchAjax(Request $request){
        $currentUserId = Auth::id();
        $keyword = $request->input('keyword');
        $users = User::where('name','like','%'.$keyword.'%')->where('id', '!=', $currentUserId)->get();
        return response()->json([
            'data'=>$users
        ]);
    }
}
