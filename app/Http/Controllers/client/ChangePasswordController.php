<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    //
    public function index(Request $request){
        if ($request->getMethod() =="POST"){
            $data = $request->validate([
                'new_password' => ['required', Password::min(8)->letters()->mixedCase()->symbols()->numbers(),'max:12'],
                'confirm_password'=>'required|same:new_password'
            ],[
                'new_password.required'=>'Vui lòng nhập mật khẩu',
                'new_password.min'=>'Mật khẩu tối thiểu phải có :min ký tự',
                'new_password.letters'=>'Mật khẩu phải chứa ít nhất một chữ cái.',
                'new_password.mixedCase'=>'Mật khẩu phải chứa ít nhất một chữ cái viết hoa và một chữ cái viết thường.',
                'new_password.symbols' => 'Mật khẩu phải chứa ít nhất một ký tự đặc biệt.',
                'new_password.numbers' => 'Mật khẩu phải chứa ít nhất một chữ số.',
                'new_password.max'=>'Mật khẩu tối đa 12 ký tự',
                'confirm_password.required'=>'Vui lòng xác nhận lại mật khẩu',
                'confirm_password.same'=>'Mật khẩu xác nhận không trùng với mật khẩu đã nhập'
            ]);
            $me = User::findOrFail(auth()->id());
            $me->password = bcrypt($data['new_password']);
            $me->save();
            return redirect()->back()->with('success','Mật khẩu đã được cập nhật');
        }
        return view('client.pages.change_password');
    }
}
