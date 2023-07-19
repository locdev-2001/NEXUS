<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    //
    public function login(Request $request){
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
               return redirect()->intended('/');
           }
           else{
               return redirect()->back()->withErrors(['errorLogin'=>'Sai địa chỉ Email hoặc mật khẩu']);
           }
        }
        return view('client.login');
    }
    public function register(Request $request){
        if($request->getMethod()=='POST'){
            $data = $request->validate([
                'name' => 'required|regex:/^[\pL\s_-]+$/u', // tên không được chứa ký tự đặc biệt
                'email' => 'required|email|unique:tgz_users,email',
                'password' => ['required', Password::min(8)->letters()->mixedCase()->symbols()->numbers(),'max:12'],
                'passwordConfirmation'=>'required|same:password'
            ],[
                'name.required'=>'Vui lòng điền Họ và tên',
                'name.regex'=>'Tên không được chứa các ký tự đặc biệt',
                'email.required'=>'Vui lòng điền Email',
                'email.email'=>'Email không đúng định dạng',
                'email.unique'=>'Email đã tồn tại',
                'password.required'=>'Vui lòng nhập mật khẩu',
                'password.min'=>'Mật khẩu tối thiểu phải có :min ký tự',
                'password.letters'=>'Mật khẩu phải chứa ít nhất một chữ cái.',
                'password.mixedCase'=>'Mật khẩu phải chứa ít nhất một chữ cái viết hoa và một chữ cái viết thường.',
                'password.symbols' => 'Mật khẩu phải chứa ít nhất một ký tự đặc biệt.',
                'password.numbers' => 'Mật khẩu phải chứa ít nhất một chữ số.',
                'password.max'=>'Mật khẩu tối đa 12 ký tự',
                'passwordConfirmation.required'=>'Vui lòng xác nhận lại mật khẩu',
                'passwordConfirmation.same'=>'Mật khẩu xác nhận không trùng với mật khẩu đã nhập'
            ]);
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            return redirect('/login');
        }
        return view('client.register');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    //dang nhap bang facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    //xu ly dang nhap facebook
    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();
        $user = User::where('email', $facebookUser->getEmail())->first();

        if (!$user) {
            // Tạo người dùng mới nếu chưa tồn tại trong hệ thống
            $user = User::create([
                'name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
                'password' => Hash::make($facebookUser->getId()) // sử dụng facebook ID làm mật khẩu
            ]);
        }

        // Đăng nhập người dùng
        Auth::login($user);

        // Chuyển hướng sau khi đăng nhập thành công
        return redirect('/');
    }
}
