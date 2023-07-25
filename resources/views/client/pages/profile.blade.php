@extends('client.pages.layout')
@section('main-content')
<div class="profile-container">
    <img src="{{asset('storage/client/images/cover.png')}}" class="coverImage" alt="">
    <div class="dashboard">
        <div class="left-dashboard">
            <img src="{{asset('storage/client/images/profile-pic.jpg')}}" class="dashboard-img" alt="">
            <div class="left-dashboard-info">
                <h1>{{$user->name}}</h1>
                <p>120 bạn bè</p>
                <div class="mutual-friend-images">
                    <img src="{{asset('storage/client/images/member-1.png')}}" alt="">
                    <img src="{{asset('storage/client/images/member-2.png')}}" alt="">
                    <img src="{{asset('storage/client/images/member-3.png')}}" alt="">
                    <img src="{{asset('storage/client/images/member-5.png')}}" alt="">
                </div>
            </div>
        </div>
        <div class="right-dashboard-info">
            <div class="right-dashboard-info-top">
                @if(UserHelpers::getId() !== $user->id)
                    <button type="button" id="sendFriendRequest"><i class="fas fa-user-plus"></i>Thêm bạn</button>
                    <button type="button"><i class="far fa-envelope"></i> Nhắn tin</button>
                @else
                    <button type="button"><i class="fa-solid fa-plus"></i> Thêm vào tin</button>
                    <button type="button"><i class="fa-solid fa-pen"></i> Chỉnh sửa trang cá nhân</button>
                @endif

            </div>
            <div class="right-div-single-logo"> <a href="" title="Những người bạn có thể biết"> <i class="fas fa-ellipsis-h"></i></a></div>
        </div>
    </div>


    <div class="container content-profile-container">
        <div class="left-sidebar profile-left-sidebar">
            <div class="left-profile-sidebar-top">
                <div class="intro-bio">
                    <h4>Giới thiệu</h4>
                    <p>Belive in yourself and you do unbelievable things <i class="far fa-smile-beam"></i></p>
                    <hr>
                </div>
                <div class="background-details">
                    <a href="#"><i class="fas fa-briefcase"></i>
                        <p>Freelancer on Fiverr</p>
                    </a>
                    <a href="#"><i class="fas fa-graduation-cap"></i>
                        <p>Studied bsc at Choumuhoni Collage</p>
                    </a>
                    <a href="#"><i class="fas fa-user-graduate"></i>
                        <p>Went to Technical School & Collage</p>
                    </a>
                    <a href="#"><i class="fas fa-home"></i>
                        <p>Lives in Noakhali, Chittagong</p>
                    </a>
                    <a href="#"><i class="fas fa-map-marker-alt"></i>
                        <p>From Chittagong, Bangladesh</p>
                    </a>
                </div>
            </div>

            <div class="left-profile-sidebar-top gallery">
                <div class="heading-link profile-heading-link">
                    <h4>Photos</h4>
                    <a href="">All Photos</a>
                </div>

                <div class="gallery-photos">
                    <div class="gallery-photos-rowFirst">
                        <img src="{{asset('storage/client/images/photo1.png')}}" alt="">
                        <img src="{{asset('storage/client/images/photo2.png')}}" alt="">
                        <img src="{{asset('storage/client/images/photo3.png')}}" alt="">

                        <img src="{{asset('storage/client/images/photo4.png')}}" alt="">
                        <img src="{{asset('storage/client/images/photo5.png')}}" alt="">
                        <img src="{{asset('storage/client/images/photo6.png')}}" alt="">
                    </div>
                </div>
            </div>

            <div class="left-profile-sidebar-top gallery">
                <div class="heading-link profile-heading-link">
                    <h4>Friends</h4>
                    <a href="">All Friends</a>
                </div>

                <div class="gallery-photos">
                    <div class="gallery-photos-rowFirst">
                        <div class="first-friend">
                            <img src="{{asset('storage/client/images/member-1.png')}}" alt="">
                            <p>Nathan M</p>
                        </div>
                        <div class="second-friend">
                            <img src="{{asset('storage/client/images/member-2.png')}}" alt="">
                            <p>Joseph N</p>
                        </div>
                        <div class="third-friend">
                            <img src="{{asset('storage/client/images/member-3.png')}}" alt="">
                            <p>Blondie K</p>
                        </div>
                        <div class="forth-friend">
                            <img src="{{asset('storage/client/images/member-4.png')}}" alt="">
                            <p>Jonathon J</p>
                        </div>
                        <div class="fifth-friend">
                            <img src="{{asset('storage/client/images/member-5.png')}}" alt="">
                            <p>Mark K</p>
                        </div>
                        <div class="sixth-friend">
                            <img src="{{asset('storage/client/images/member-6.png')}}" alt="">
                            <p>Emilia M</p>
                        </div>
                        <div class="seventh-friend">
                            <img src="{{asset('storage/client/images/member-7.png')}}" alt="">
                            <p>Max P</p>
                        </div>
                        <div class="eighth-friend">
                            <img src="{{asset('storage/client/images/member-8.png')}}" alt="">
                            <p>Layla M</p>
                        </div>
                        <div class="ninth-friend">
                            <img src="{{asset('storage/client/images/member-9.png')}}" alt="">
                            <p>Edward M</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- main-content------- -->

        <div class="content-area profile-content-area">
            <div class="write-post-container">
                <div class="user-profile">
                    <img src="{{asset('storage/client/images/profile-pic.jpg')}}" alt="">
                    <div>
                        <p>{{$user->name}}</p>
                        <small>Công khai <i class="fa-solid fa-earth-asia"></i> <i class="fas fa-caret-down"></i></small>
                    </div>
                </div>

                <div class="post-upload-textarea">
                    <textarea name="" placeholder="Bạn đang nghĩ gì?" id="" cols="30" rows="3"></textarea>
                    <div class="add-post-links">
                        <a href="#"><img src="{{asset('storage/client/images/live-video.png')}}" alt="">Live Video</a>
                        <a href="#"><img src="{{asset('storage/client/images/photo.png')}}" alt="">Photo/Video</a>
                        <a href="#"><img src="{{asset('storage/client/images/feeling.png')}}" alt="">Feeling Activity</a>
                    </div>
                </div>
            </div>

            <div class="status-field-container write-post-container">
                <div class="user-profile-box">
                    <div class="user-profile">
                        <img src="images/profile-pic.png" alt="">
                        <div>
                            <p>{{$user->name}}</p>
                            <small>August 13 1999, 09.18 pm</small>
                        </div>
                    </div>
                    <div>
                        <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                </div>
                <div class="status-field">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis dolores praesentium dicta
                        laborum nihil accusantium odit laboriosam, sed sit autem! <a
                            href="#">#This_Post_is_Better!!!!</a>
                    </p>
                    <img src="images/feed-image-1.png" alt="">

                </div>
                <div class="post-reaction">
                    <div class="activity-icons">
                        <div><img src="images/like-blue.png" alt="">120</div>
                        <div><img src="images/comments.png" alt="">52</div>
                        <div><img src="images/share.png" alt="">35</div>
                    </div>
                    <div class="post-profile-picture">
                        <img src="images/profile-pic.png " alt=""> <i class=" fas fa-caret-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
