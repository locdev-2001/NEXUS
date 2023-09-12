<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nexus</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{asset('storage/client/images/logo/logo.svg')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modaal@0.4.4/dist/css/modaal.min.css" integrity="sha256-uXhoVqsazfMtamqLl8uOpYKcZ7bRUZWDmoLcPOpeApw=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" integrity="sha512-Z/def5z5u2aR89OuzYcxmDJ0Bnd5V1cKqBEbvLOiUNWdg9PQeXVvXLI90SE4QOHGlfLqUnDNVAYyZi8UwUTmWQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/helvetica.css') }}">
    <link rel="stylesheet" href="{{asset('storage/client/css/index.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @livewireStyles
</head>

<body>
<?php
use App\Helpers\UserHelpers;
$userHelpers = new UserHelpers();
$authInf = $userHelpers->getUser();
$authId = $userHelpers->getId();
$authProfile = $userHelpers->getProfile();
$notifications = $userHelpers->getNotifications();
?>
<input type="hidden" id="avatar-hidden" value="{{$authProfile->avatar}}">
<nav class="navbar">
    <div class="nav-left">
        <a href="/"><img class="logo" src="{{asset('storage/client/images/logo/nav-logo.png')}}" alt="nav-logo"></a>
        <ul class="navlogo">
            <a href="/"><li><i class="fa-solid fa-house-chimney"></i></li></a>
            <li class="notify" id="notify"><i class="fa-solid fa-bell"></i></li>
            <div class="user-notification" id="user-notification">
                <div class="notifications-header">
                    <div class="wrapper-header">
                        <h1 class="header">Thông báo</h1>
                    </div>
                    <div class="notification-actions">
                        <span><i class="fa-solid fa-ellipsis"></i></span>
                    </div>
                </div>
                @if(count($notifications) >0)
                    @foreach($notifications as $notification)
                        <a class="hyper_link" href="{{url($notification->hyper_link)}}">
                        <div class="notification" id="n-{{$notification->id}}">
                            @if(json_decode($notification->type == 1 || $notification->type == 2))
                                    <div class="avatar-container">
                                        <img class="avatar" src="{{asset(json_decode($notification->data)->avatar)}}" alt="">
                                    </div>
                                    <div class="notifications-message">
                                        <p class="message" id="message">{{json_decode($notification->data)->message}}</p>
                                        @if(isset(json_decode($notification->data)->action_url))
                                        <a href="{{ json_decode($notification->data)->action_url }}" class="btn btn-primary accept-btn">{{ json_decode($notification->data)->action_text }}</a>
                                        @endif
                                        @if(isset(json_decode($notification->data)->reject_url))
                                        <a href="{{ json_decode($notification->data)->reject_url}}" class="btn btn-danger reject-btn">{{ json_decode($notification->data)->reject_text }}</a>
                                        @endif
                                        <div class="notifications-time">
                                            <span>{{$userHelpers->getTimeAgoAtrr($notification->created_at)}}</span>
                                        </div>
                                    </div>
                            @elseif(json_decode($notification->type == 3))
                                <div class="avatar-container">
                                <img class="avatar" src="{{asset(json_decode($notification->data)->avatar)}}" alt="">
                                @if(json_decode($notification->data)->reaction_type == 1)
                                <img src="{{asset('storage/client/images/emoji/like.svg')}}" class="emoji" alt="like">
                                @elseif(json_decode($notification->data)->reaction_type == 2)
                                <img src="{{asset('storage/client/images/emoji/love.svg')}}" class="emoji" alt="love">
                                @elseif(json_decode($notification->data)->reaction_type == 3)
                                <img src="{{asset('storage/client/images/emoji/haha.svg')}}" class="emoji" alt="haha">
                                @elseif(json_decode($notification->data)->reaction_type == 4)
                                <img src="{{asset('storage/client/images/emoji/wow.svg')}}" class="emoji" alt="wow">
                                @elseif(json_decode($notification->data)->reaction_type == 5)
                                <img src="{{asset('storage/client/images/emoji/sad.svg')}}" class="emoji" alt="sad">
                                @else
                                <img src="{{asset('storage/client/images/emoji/angry.svg')}}" class="emoji" alt="angry">
                                @endif
                                </div>
                                <div class="notifications-message">
                                    <p class="message" id="message">{{json_decode($notification->data)->message}}</p>
                                    <div class="notifications-time">
                                        <span>{{$userHelpers->getTimeAgoAtrr($notification->created_at)}}</span>
                                    </div>
                                </div>
                                @elseif(json_decode($notification->type >3 && $notification->type <=5 ))
                                    <div class="avatar-container">
                                        <img src="{{asset(json_decode($notification->data)->avatar)}}" alt="" class="avatar">
                                        <img src="{{asset('storage/client/images/icons/message.svg')}}" alt="comment" class="comment">
                                    </div>
                                    <div class="notifications-message">
                                        <p class="message" id="message">{{json_decode($notification->data)->message}}</p>
                                        <div class="notifications-time">
                                            <span>{{$userHelpers->getTimeAgoAtrr($notification->created_at)}}</span>
                                        </div>
                                    </div>
                                @else
                                <div class="avatar-container">
                                    <img src="{{asset(json_decode($notification->data)->avatar)}}" alt="" class="avatar">
                                    <img src="{{asset('storage/client/images/emoji/like.svg')}}" alt="emoji" class="emoji">
                                </div>
                                <div class="notifications-message">
                                    <p class="message" id="message">{{json_decode($notification->data)->message}}</p>
                                    <div class="notifications-time">
                                        <span>{{$userHelpers->getTimeAgoAtrr($notification->created_at)}}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        </a>
                    @endforeach
                @else
                    <div class="notification" id="no-notifications">
                        <p>Chưa có thông báo</p>
                    </div>
                @endif
            </div>
            <li><a class="hyper_link" href="/messenger/users"><i class="fa-solid fa-comment"></i></a></li>
            <li><i class="fa-solid fa-bars"></i></li>
        </ul>
    </div>
    <div class="nav-right">
        <div class="search">
        <div class="search-box">
            <img src="{{asset('storage/client/images/search.png')}}" alt="">
            <input type="text" placeholder="Search" name="search_profile" id="search_profile">
        </div>
        <div class="results-container">
            <div class="results hide">
            </div>
        </div>
        </div>
        <div class="profile-image online" onclick="UserSettingToggle()">
            <img src="{{asset($authProfile->avatar)}}" alt="">
        </div>

    </div>
    <div class="user-settings">
        <div class="profile-darkButton">
            <div class="user-profile">
                <img src="{{asset($authProfile->avatar)}}" alt="">
                <div>
                    <p>{{$authInf->name}}</p>
                    <input type="hidden" id="user-id_hidden" data-user_id="{{$authId}}">
                    <a href="/profile?id={{UserHelpers::getId()}}">Hồ sơ của bạn</a>
                </div>
            </div>
            <div id="dark-button" onclick="darkModeON()">
                <span></span>
            </div>
        </div>
        <hr>
        <div class="user-profile">
            <img src="{{asset('storage/client/images/feedback.png')}}" alt="">
            <div>
                <p>Phản hồi</p>
                <a href="">Giúp chúng tôi cải thiện</a>
            </div>
        </div>
        <hr>
        <div class="settings-links">
            <img src="{{asset('storage/client/images/setting.png')}}" alt="" class="settings-icon">
            <a href="#">Cài đặt và quyền riêng tư <img src="{{asset('storage/client/images/arrow.png')}}" alt=""></a>
        </div>

        <div class="settings-links">
            <img src="{{asset('storage/client/images/help.png')}}" alt="" class="settings-icon">
            <a href="#">Hỗ trợ và giải đáp <img src="{{asset('storage/client/images/arrow.png')}}" alt=""></a>
        </div>

        <div class="settings-links">
            <img src="{{asset('storage/client/images/Display.png')}}" alt="" class="settings-icon">
            <a href="#">Hiển thị và tương tác <img src="{{asset('storage/client/images/arrow.png')}}" alt=""></a>
        </div>

        <div class="settings-links">
            <img src="{{asset('storage/client/images/logout.png')}}" alt="" class="settings-icon">
            <a href="/logout">Đăng xuất <img src="{{asset('storage/client/images/arrow.png')}}" alt=""></a>
        </div>

    </div>
</nav>

<!-- content-area------------ -->

<div class="container-custom">
    <!-- main-content------- -->
    @yield('main-content')
</div>
<footer id="footer">
    <p style="color: black"> Copyright 2023 - NEXUS &copy;</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/modaal@0.4.4/dist/js/modaal.min.js" integrity="sha256-e8kfivdhut3LQd71YXKqOdkWAG1JKiOs2hqYJTe0uTk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha512-3dZ9wIrMMij8rOH7X3kLfXAzwtcHpuYpEgQg1OA4QAob1e81H8ntUQmQm3pBudqIoySO5j0tHN4ENzA6+n2r4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.4.0/color-thief.min.js" integrity="sha512-r2yd2GP87iHAsf2K+ARvu01VtR7Bs04la0geDLbFlB/38AruUbA5qfmtXwXx6FZBQGJRogiPtEqtfk/fnQfaYA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('storage/client/js/pusher.js')}}"></script>
<script src="{{asset('storage/client/js/index.js')}}"></script>
@yield('script-bottom')
@livewireScripts
</body>
</html>
