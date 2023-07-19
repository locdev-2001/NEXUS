<?php

use App\Http\Controllers\client\AuthController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\ProfileController;
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
    Route::any('/profile',[ProfileController::class,'index'])->name('client.profile');
});
//dang nhap bang facebook
Route::group(['prefix'=>'auth/facebook'], function (){
    Route::get('/redirect',[AuthController::class,'redirectToFacebook'])->name('auth.facebook.redirect');
    Route::get('/callback',[AuthController::class,'handleFacebookCallback'])->name('auth.facebook.callback');
});


Route::any('/login',[AuthController::class,'login'])->name('client.login');
Route::any('/register',[AuthController::class,'register'])->name('client.register');


