<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Auth;

class user{
    public function getUser(){
       return Auth::user();
    }
    public function getId(){
        return Auth::id();
    }
}
