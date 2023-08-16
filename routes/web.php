<?php

use App\Http\Controllers\client\AuthController;
use App\Http\Controllers\client\CommentController;
use App\Http\Controllers\client\FriendController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\MediaController;
use App\Http\Controllers\client\PostController;
use App\Http\Controllers\client\ProfileController;
use App\Http\Controllers\client\ReactionController;
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
Route::group(['middleware'=>'login'],function (){
    Route::any('/', [HomeController::class,'index'])->name('client.home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('client.logout');
    Route::group(['prefix'=>'/profile'],function(){
        Route::any('',[ProfileController::class,'index'])->name('client.profile');
        Route::any('/search',[ProfileController::class,'searchAjax'])->name('client.profile.searchAjax');
    });
    Route::post('/send-friend-request',[FriendController::class,'sendRequest'])->name('client.friend.sendRequest');
    Route::group(['prefix'=>'/post'],function (){
        Route::post('/create',[PostController::class,'createPost'])->name('client.createPost');
        Route::post('/media/store',[MediaController::class,'storeMedia'])->name('client.storeMedia');
        Route::post('media/delete',[MediaController::class,'deleteMedia'])->name('client.deleteMedia');
    });
    Route::group(['prefix'=>'comment'],function(){
        Route::post('/create',[CommentController::class,'create'])->name('client.comment');
        Route::post('/reply',[CommentController::class,'reply'])->name('client.reply');
    });
    Route::any('/accept-friend-request',[FriendController::class,'accept'])->name('client.accept.friend.request');
    Route::any('/reject-friend-request',[FriendController::class,'reject'])->name('client.reject.friend.request');
    Route::post('/reaction-post',[ReactionController::class,'reaction'])->name('client.reaction');
});
//dang nhap bang facebook
Route::group(['prefix'=>'auth/facebook'], function (){
    Route::get('/redirect',[AuthController::class,'redirectToFacebook'])->name('auth.facebook.redirect');
    Route::get('/callback',[AuthController::class,'handleFacebookCallback'])->name('auth.facebook.callback');
});


Route::any('/login',[AuthController::class,'login'])->name('client.login');
Route::any('/register',[AuthController::class,'register'])->name('client.register');


