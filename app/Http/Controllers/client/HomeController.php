<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    protected $_data = [
        'title'=>'Trang chủ'
    ];
    public function index(){
        return view('client.pages.index',$this->_data);
    }
}
