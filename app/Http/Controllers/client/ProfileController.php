<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    protected $_data=[];
    public function index(Request $request){
        $user_id = $request->query('id');
        $user = User::where('id',$user_id)->first();
        $this->_data['user'] =$user;
        return view('client.pages.profile',$this->_data);
    }
}
