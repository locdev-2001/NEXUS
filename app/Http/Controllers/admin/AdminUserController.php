<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Post_comments;
use App\Models\Post_reactions;
use App\Models\Posts;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    //
    public function index(){
        return view('admin.users');
    }
    public function edit(Request $request,$id){
        $user = User::with('profile')->findOrFail($id);
        // dd( Carbon::now());
//        dd($user);
        if ($request->getMethod()=="POST"){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
            ], [
                'name.required' => 'Tên người dùng không được để trống',
                'email.required' => 'email không được để trống',
            ]);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if ($request->input('password')  == ''){
                $password = $user->password;
            }
            else{
                $password = bcrypt($request->input('password'));
            }
            $user->password = $password;
            $user->save();
            return redirect('/admin/users')->with('success', 'Người dùng đã được cập nhật');
        }
        return view('admin.edit_user', ['user' => $user]);
    }
    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        $profile = Profile::where('user_id',$user->id)->delete();
        $post = Posts::where('user_id',$user->id)->delete();
        $postCmt = Post_comments::where('user_id',$user->id)->delete();
        $postReact = Post_reactions::where('user_id',$user->id)->delete();
        $media = Media::where('user_id',$user->id)->delete();
        return redirect('/admin/users')->with('success', 'Xóa người dùng thành công');
    }
}
