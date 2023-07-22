<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Auth;

class UserHelpers{
    public function getUser(){
       return Auth::user();
    }
    public static function getId(){
        return Auth::id();
    }
}
