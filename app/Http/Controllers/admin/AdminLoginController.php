<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    //
    public function index(Request $request){
        if($request->getMethod() =='POST'){
            $credentials = $request->validate([
                'email'=>'required|email',
                'password'=>'required'
            ],[
                'email.required'=>'Vui lòng nhập địa chỉ Email',
                'email.email'=>'Địa chỉ email không đúng định dạng',
                'password.required'=>'Vui lòng nhập mật khẩu'
            ]);
            if(Auth::attempt($credentials)){
                return redirect()->intended('/admin');
            }
            else{
                return redirect()->back()->withErrors(['errorLogin'=>'Sai địa chỉ Email hoặc mật khẩu']);
            }
        }
        return view('admin.login');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
