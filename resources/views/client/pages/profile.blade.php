@extends('client.pages.layout')
@section('main-content')
    <?php
    use App\Helpers\UserHelpers;
    $userHelpers = new UserHelpers();
    $authInf = $userHelpers->getUser();
    $authId = $userHelpers->getId();
    $friendRequest = $userHelpers::getFriendRequest($user->id);
    $isFriend = $userHelpers::isFriend($user->id);
    ?>
<div class="profile-container">
    <img src="{{asset($profile->cover)}}" class="coverImage" alt="">
    <div class="dashboard">
        <div class="left-dashboard">
            <img src="{{asset($profile->avatar)}}" class="dashboard-img" alt="">
            <div class="left-dashboard-info">
                <h1>{{$user->name}}</h1>
                <p>{{count($friends)}} bạn bè</p>
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
                    @if($friendRequest)
                       <?php
                            $senderId = $friendRequest['sender_id'] ?? null;
                        ?>
                        @if($senderId)
                            @if($senderId === auth()->id())
                            <button class="pending" type="button" id="pendingBtn" data-user_id ="{{$user->id}}">&#xf00c Đã gửi lời mời kết bạn</button>
                            @else
                                <button id="acceptBtn">Chấp nhận</button>
                                <button id="rejectBtn">Từ chối</button>
                            @endif
                        @else
                            <button type="button" id="sendFriendRequest" data-user_id="{{$user->id}}" data-status="1"><i class="fas fa-user-plus"></i>Thêm bạn</button>
                        @endif

                        @elseif($isFriend === true)
                            <button id="friend-accepted"><i class="fa-solid fa-check"></i> Bạn bè</button>
                        @else
                    <button type="button" id="sendFriendRequest" data-user_id="{{$user->id}}" data-status="1"><i class="fas fa-user-plus"></i>Thêm bạn</button>
                    @endif
                    <button type="button"><i class="far fa-envelope"></i> Nhắn tin</button>
                @else
                    <button type="button"><i class="fa-solid fa-plus"></i> Thêm vào tin</button>
                    <button type="button" class="edit-profile"><i class="fa-solid fa-pen"></i> Chỉnh sửa trang cá nhân</button>
                @endif

            </div>
            <div class="right-div-single-logo"> <a href="" title="Những người bạn có thể biết"> <i class="fas fa-ellipsis-h"></i></a></div>
        </div>
    </div>

    <div id="profile-modal" style="display:none;">
        <div class="profile-modal-header">
            <h1>Chỉnh sửa trang cá nhân</h1>
        </div>
        <div class="component" id="avatar-component">
            <div class="component-header">
                <h1>Ảnh đại diện</h1>
                <button type="button" class="edit-profile-btn" id="edit-avatar">Chỉnh sửa</button>
            </div>
            <div class="avatar-image" id="avatar-image">
                <img src="{{asset($profile->avatar)}}" class="avatar" alt="">
            </div>
        </div>
        <div class="component" id="cover-component">
            <div class="component-header">
                <h1>Ảnh bìa</h1>
                <button type="button" class="edit-profile-btn" id="edit-cover">Chỉnh sửa</button>
            </div>
            <div class="cover-image" id="cover-image">
                <img src="{{asset($profile->cover)}}" class="cover" alt="">
            </div>
        </div>
    </div>

    <div class="container-custom content-profile-container">
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
                <div class="user-profile" style="padding: 10px">
                    <a href="/profile?id={{UserHelpers::getId()}}"><img src="{{asset('storage/client/images/profile-pic.jpg')}}"></a>
                    <div class="timeline_nexus">
                        <a class="modaal-popup" href="#post-upload"><span class="input000">Bạn đang nghĩ gì thế, {{$authInf->name}} ?</span></a>
                    </div>
                </div>
            </div>
            <div class="write-post-container" id="post-upload" style="display: none">
                <form action="{{route('client.createPost')}}" method="POST" enctype="multipart/form-data" id="nexus_timeline">
                    @csrf
                    <div class="user-profile">
                        <a href="/profile?id={{UserHelpers::getId()}}"><img src="{{asset('storage/client/images/profile-pic.jpg')}}" alt=""></a>
                        <div>
                            <p>{{$authInf->name}}</p>
                            <select name="post_mode" id="post_mode">
                                <option class="mode" value="1">Công khai &#xf57e</option>
                                <option class="mode" value="2">Bạn bè &#xf500</option>
                                <option class="mode" value="3">Chỉ mình tôi &#xf023</option>
                            </select>
                        </div>
                    </div>
                    <div class="post-upload-textarea">
                        <textarea name="content_text" placeholder="Bạn đang nghĩ gì, {{$authInf->name}} ?" id="content_text"></textarea>
                        <div class="form-group media-container">
                            <div class="needsclick dropzone" id="document-dropzone">

                            </div>
                            <div id="gallery"></div>
                        </div>
                        <div class="add-post-links">
                            <a href=""><img src="{{asset('storage/client/images/live-video.png')}}" alt="">Live Video</a>
                            <a href="" id="addMediaBtn"><img src="{{asset('storage/client/images/photo.png')}}" alt="">Photo/Video</a>
                            <a href=""><img src="{{asset('storage/client/images/feeling.png')}}" alt="">Feeling Activity</a>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit-post">Đăng</button>
                </form>
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
@section('script-bottom')
    <script>
        let arrImg =[];
        $('#gallery').imagesGrid({
            images: arrImg,
            align: true,
            onGridRendered: function($grid) { },
            getViewAllText: function(imagesCount) {
                return '+' + imagesCount;
            }
        });
        let uploadedDocumentMap = {}
        Dropzone.options.documentDropzone={
            dictDefaultMessage: '<div class="drop-media-btn"><i class="fa-solid fa-square-plus"></i> '+ '<span>Thêm ảnh/video</span><p class="drag-n-drop">hoặc kéo và thả</p></div>',
            dictFileUploaded: "Tải lên thành công!",
            dictError: "Có lỗi xảy ra trong quá trình tải lên.",
            dictRemoveFile:'<i class="fa-solid fa-trash"></i>',
            addRemoveLinks:true,
            url:'{{route('client.storeMedia')}}',
            maxFilesize:25, //MB
            headers:{
                'X-CSRF-TOKEN':"{{csrf_token()}}"
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
                let imageUrl = response.name;//đường dẫn của hình ảnh sau khi upload
                arrImg.push('{{asset('storage')}}'+'/'+imageUrl);
                updateImagesGrid(arrImg);
            },
            removedfile:function (file) {
                file.previewElement.remove()
                let name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="document[]"][value="' + name + '"]').remove()
                arrImg = arrImg.filter(function (image){
                    return image !== '{{asset('storage')}}'+'/'+name;
                })
                updateImagesGrid(arrImg);
                $.ajax({
                    url: '{{route('client.deleteMedia')}}',
                    headers:{
                        'X-CSRF-TOKEN':"{{csrf_token()}}"
                    },
                    type: 'POST',
                    data: { media: name },
                    success: function(response) {
                        console.log('success remove',response)
                    },
                    error: function(error) {
                        console.error(error)
                    }
                });
            },
            init:function (){

            }
        }
        function updateImagesGrid(arrImg){
            $('#gallery').imagesGrid({
                images: arrImg,
                align:true,
                getViewAllText: function(imagesCount) {
                    return '+' + imagesCount;
                }
            })
        }
        {{--const postsData = {!! $posts !!};--}}
        {{--postsData.forEach((post) => {--}}
        {{--    // Tạo một div mới cho mỗi bài viết--}}
        {{--    const imageSources = post.media_dir.map(function(m){--}}
        {{--        m = "{{asset('storage')}}"+"/"+m--}}
        {{--        return m--}}
        {{--    })--}}
        {{--    const postId = post.id--}}
        {{--    // Lặp qua các đường dẫn hình ảnh của bài viết và tạo các thẻ img tương ứng--}}
        {{--    displayImageGrid(imageSources,postId)--}}
        {{--})--}}
        {{--function displayImageGrid(imgArr,postId){--}}
        {{--    $("#si-"+postId).imagesGrid({--}}
        {{--        images:imgArr,--}}
        {{--        align: true,--}}
        {{--        cells:4,--}}
        {{--        getViewAllText: function (imagesCount) {--}}
        {{--            return "+" + imagesCount;--}}
        {{--        },--}}
        {{--    });--}}
        {{--}--}}
    </script>
@endsection
