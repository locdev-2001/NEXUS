<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{asset('storage/client/images/logo/logo.svg')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modaal@0.4.4/dist/css/modaal.min.css" integrity="sha256-uXhoVqsazfMtamqLl8uOpYKcZ7bRUZWDmoLcPOpeApw=" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('storage/client/css/index.css')}}">
</head>

<body>
<nav class="navbar">
    <div class="nav-left">
        <img class="logo" src="{{asset('storage/client/images/logo/nav-logo.png')}}" alt="nav-logo">
        <ul class="navlogo">
            <li><i class="fa-solid fa-bell"></i></li>
            <li><i class="fa-solid fa-comment"></i></li>
            <li><i class="fa-solid fa-bars"></i></li>
        </ul>
    </div>
    <div class="nav-right">
        <div class="search-box">
            <img src="{{asset('storage/client/images/search.png')}}" alt="">
            <input type="text" placeholder="Search">
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
                    <p>{{User::getUser()->name}}</p>
                    <a href="/profile?id={{User::getId()}}">Hồ sơ của bạn</a>
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
    <p>&copy; Copyright 2021 - Socialbook All Rights Reserved</p>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/modaal@0.4.4/dist/js/modaal.min.js" integrity="sha256-e8kfivdhut3LQd71YXKqOdkWAG1JKiOs2hqYJTe0uTk=" crossorigin="anonymous"></script>
<script src="{{asset('storage/client/js/index.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
