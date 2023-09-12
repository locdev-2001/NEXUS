<?php

use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\AdminPostController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\client\AuthController;
use App\Http\Controllers\client\CommentController;
use App\Http\Controllers\client\FriendController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\MediaController;
use App\Http\Controllers\client\PostController;
use App\Http\Controllers\client\ProfileController;
use App\Http\Controllers\client\ReactionController;
use App\Http\Livewire\Chat\CreateChat;
use App\Http\Livewire\Chat\Main;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>'adminLogin'],function(){
    Route::group(['prefix'=>'admin'],function(){
        Route::any('/',[AdminHomeController::class,'index'])->name('admin.home');
        Route::any('/logout',[AdminLoginController::class,'logout'])->name('admin.logout');
        Route::any('/users',[AdminUserController::class,'index'])->name('admin.users');
        Route::any('/edit_user/{ID}',[AdminUserController::class,'edit'])->name('admin.edit.user');
        Route::any('/delete/{ID}',[AdminUserController::class,'delete'])->name('admin.delete.user');
        Route::any('/posts',[AdminPostController::class,'index'])->name('admin.posts');
        Route::any('/delete_post/{ID}',[AdminPostController::class,'delete'])->name('admin.delete.post');
    });

});
Route::any('/admin/login',[AdminLoginController::class,'index'])->name('admin.login');

Route::group(['middleware'=>'login'],function (){
    Route::any('/', [HomeController::class,'index'])->name('client.home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('client.logout');
    Route::group(['prefix'=>'/profile'],function(){
        Route::any('',[ProfileController::class,'index'])->name('client.profile');
        Route::any('/search',[ProfileController::class,'searchAjax'])->name('client.profile.searchAjax');
        Route::any('/avatar/ajax/save',[ProfileController::class,'saveAvatar'])->name('client.profile.saveAvatar');
        Route::any('/cover/ajax/save',[ProfileController::class,'saveCover'])->name('client.profile.saveCover');
        Route::any('/bio/ajax/save',[ProfileController::class,'saveBio'])->name('client.profile.saveBio');
    });
    Route::post('/send-friend-request',[FriendController::class,'sendRequest'])->name('client.friend.sendRequest');
    Route::group(['prefix'=>'/post'],function (){
        Route::any('',[PostController::class,'index'])->name('client.post');
        Route::post('/create',[PostController::class,'createPost'])->name('client.createPost');
        Route::post('/media/store',[MediaController::class,'storeMedia'])->name('client.storeMedia');
        Route::post('media/delete',[MediaController::class,'deleteMedia'])->name('client.deleteMedia');
        Route::post('/edit-post',[PostController::class,'edit'])->name('client.edit.post');
        Route::post('/delete-post',[PostController::class,'delete'])->name('client.delete.post');
    });
    Route::group(['prefix'=>'comment'],function(){
        Route::post('/create',[CommentController::class,'create'])->name('client.comment');
        Route::post('/reply',[CommentController::class,'reply'])->name('client.reply');
        Route::post('/reaction',[CommentController::class,'reaction'])->name('client.reactionComment');
    });
    Route::any('/accept-friend-request',[FriendController::class,'accept'])->name('client.accept.friend.request');
    Route::any('/reject-friend-request',[FriendController::class,'reject'])->name('client.reject.friend.request');
    Route::post('/reaction-post',[ReactionController::class,'reaction'])->name('client.reaction');
    Route::group(['prefix'=>'messenger'],function(){
        Route::get('/users',CreateChat::class)->name('messenger.users');
        Route::get('/chat{key?}',Main::class)->name('messenger.chat');
    });
    Route::get('/dashboard',function (){
        return view('dashboard');
    })->middleware('auth')->name('dashboard');
});
//dang nhap bang facebook
Route::group(['prefix'=>'auth/facebook'], function (){
    Route::get('/redirect',[AuthController::class,'redirectToFacebook'])->name('auth.facebook.redirect');
    Route::get('/callback',[AuthController::class,'handleFacebookCallback'])->name('auth.facebook.callback');
});


Route::any('/login',[AuthController::class,'login'])->name('client.login');
Route::any('/register',[AuthController::class,'register'])->name('client.register');

require __DIR__.'/auth.php';
