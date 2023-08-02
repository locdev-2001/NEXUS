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
    <link rel="stylesheet" href="{{ asset('css/helvetica.css') }}">
    <link rel="stylesheet" href="{{asset('storage/client/css/index.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>

<body>
<?php
use App\Helpers\UserHelpers;
$userHelpers = new UserHelpers();
$authInf = $userHelpers->getUser();
$authId = $userHelpers->getId();
$notifications = $userHelpers->getNotifications();
?>
<nav class="navbar">

    <div class="nav-left">
        <a href="/"><img class="logo" src="{{asset('storage/client/images/logo/nav-logo.png')}}" alt="nav-logo"></a>
        <ul class="navlogo">
            <a href="/"><li><i class="fa-solid fa-house-chimney"></i></li></a>
            <li class="notify" id="notify"><i class="fa-solid fa-bell"></i></li>
            <div class="user-notification" id="user-notification">
                @if(count($notifications) >0)
                    @foreach($notifications as $notification)
                        <div class="notification" id="n-{{$notification->id}}">
                            <img class="avatar" src="{{asset('storage/client/images/profile-pic.jpg')}}" alt="">
                            <div class="notifications-message">
                            <p class="message" id="message">{{json_decode($notification->data)->message}}</p>
                                @if(isset(json_decode($notification->data)->action_url))
                                <a href="{{ json_decode($notification->data)->action_url }}" class="btn btn-primary accept-btn">{{ json_decode($notification->data)->action_text }}</a>
                                @endif
                                @if(isset(json_decode($notification->data)->reject_url))
                                <a href="{{ json_decode($notification->data)->reject_url}}" class="btn btn-danger reject-btn">{{ json_decode($notification->data)->reject_text }}</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="notification">
                        <p>Chưa có thông báo</p>
                    </div>
                @endif
            </div>
            <li><i class="fa-solid fa-comment"></i></li>
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
            <img src="{{asset('storage/client/images/profile-pic.jpg')}}" alt="">
        </div>

    </div>
    <div class="user-settings">
        <div class="profile-darkButton">
            <div class="user-profile">
                <img src="{{asset('storage/client/images/profile-pic.jpg')}}" alt="">
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

<div class="container">
    <div class="left-sidebar">
        <div class="important-links">
            <a href="/"><img src="{{asset('storage/client/images/news.png')}}" alt="">Bảng tin</a>
            <a href=""><img src="{{asset('storage/client/images/friends.png')}}" alt="">Bạn bè</a>
            <a href=""><img src="{{asset('storage/client/images/group.png')}}" alt="">Nhóm</a>
            <a href=""><img src="{{asset('storage/client/images/marketplace.png')}}" alt="">Marketplace</a>
            <a href=""><img src="{{asset('storage/client/images/watch.png')}}" alt="">Watch</a>
            <a href="">Xem thêm</a>
        </div>

        <div class="shortcut-links">
            <p>Lối tắt của bạn</p>
            <a href="#"> <img src="{{asset('storage/client/images/shortcut-1.png')}}" alt="">Web Developers</a>
            <a href="#"> <img src="{{asset('storage/client/images/shortcut-2.png')}}" alt="">Web Design Course</a>
            <a href="#"> <img src="{{asset('storage/client/images/shortcut-3.png')}}" alt="">Full Stack Development</a>
            <a href="#"> <img src="{{asset('storage/client/images/shortcut-4.png')}}" alt="">Website Experts</a>
        </div>
    </div>

    <!-- main-content------- -->
    @yield('main-content')
</div>
<footer id="footer">
    <p> Copyright 2023 - NEXUS &copy;</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/modaal@0.4.4/dist/js/modaal.min.js" integrity="sha256-e8kfivdhut3LQd71YXKqOdkWAG1JKiOs2hqYJTe0uTk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha512-3dZ9wIrMMij8rOH7X3kLfXAzwtcHpuYpEgQg1OA4QAob1e81H8ntUQmQm3pBudqIoySO5j0tHN4ENzA6+n2r4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js"></script>
<script src="{{asset('storage/client/js/pusher.js')}}"></script>
<script src="{{asset('storage/client/js/index.js')}}"></script>
@yield('script-bottom')
</body>
</html>
