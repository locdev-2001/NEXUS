@extends('client.pages.layout')
@section('main-content')
<?php
use App\Helpers\UserHelpers;
$userHelpers = new UserHelpers();
$authInf = $userHelpers->getUser();
$authId = $userHelpers->getId();
?>
<div class="content-area">
    <div class="story-gallery">
        <div class="story story1">
            <img src="{{asset('storage/client/images/upload.png')}}" alt="">
            <p>Post Story</p>
        </div>
        <div class="story story2">
            <img src="{{asset('storage/client/images/member-1.png')}}" alt="">
            <p>Alison</p>
        </div>
        <div class="story story3">
            <img src="{{asset('storage/client/images/member-2.png')}}" alt="">
            <p>Jackson</p>
        </div>
        <div class="story story4">
            <img src="{{asset('storage/client/images/member-3.png')}}" alt="">
            <p>Samona</p>
        </div>
        <div class="story story5">
            <img src="{{asset('storage/client/images/member-4.png')}}" alt="">
            <p>John</p>
        </div>
    </div>
    <div class="write-post-container">
        <div class="user-profile">
            <img src="{{asset('storage/client/images/profile-pic.jpg')}}">
            <div class="timeline_nexus">
                <a class="modaal-popup" href="#post-upload"><span class="input000">Bạn đang nghĩ gì thế, {{$authInf->name}} ?</span></a>
            </div>
        </div>
    </div>
        <div class="write-post-container" id="post-upload" style="display: none">
            <form action="{{route('client.createPost')}}" method="POST" enctype="multipart/form-data" id="nexus_timeline">
                    @csrf
            <div class="user-profile">
                <img src="{{asset('storage/client/images/profile-pic.jpg')}}" alt="">
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
                <img src="{{asset('storage/client/images/profile-pic.jpg')}}" alt="">
                <div>
                    <p>{{$authInf->name}}</p>
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
                    href="#">#This_Post_is_Better!!!!</a> </p>
            <img src="{{asset('storage/client/images/feed-image-1.png')}}" alt="">

        </div>
        <div class="post-reaction">
            <div class="activity-icons">
                <div><img src="{{asset('storage/client/images/like-blue.png')}}" alt="">120</div>
                <div><img src="{{asset('storage/client/images/comments.png')}}" alt="">52</div>
                <div><img src="{{asset('storage/client/images/share.png')}}" alt="">35</div>
            </div>
            <div class="post-profile-picture">
                <img src="{{asset('storage/client/images/profile-pic.jpg')}} " alt=""> <i class=" fas fa-caret-down"></i>
            </div>
        </div>
    </div>
</div>

<!-- sidebar------------ -->
<div class="right-sidebar">
    <div class="heading-link">
        <h4>Events</h4>
        <a href="">See All</a>
    </div>

    <div class="events">
        <div class="left-event">
            <h4>13</h4>
            <span>august</span>
        </div>
        <div class="right-event">
            <h4>Social Media</h4>
            <p> <i class="fas fa-map-marker-alt"></i> wisdom em Park</p>
            <a href="#">More Info</a>
        </div>
    </div>
    <div class="events">
        <div class="left-event">
            <h4>18</h4>
            <span>January</span>
        </div>
        <div class="right-event">
            <h4>Mobile Marketing</h4>
            <p><i class="fas fa-map-marker-alt"></i> wisdom em Park</p>
            <a href="#">More Info</a>
        </div>
    </div>

    <div class="heading-link">
        <h4>Advertisement</h4>
        <a href="">Close</a>
    </div>
    <div class="advertisement">
        <img src="{{asset('storage/client/images/advertisement.png')}}" class="advertisement-image" alt="">
    </div>

    <div class="heading-link">
        <h4>Conversation</h4>
        <a href="">Hide Chat</a>
    </div>

    <div class="online-list">
        <div class="online">
            <img src="{{asset('storage/client/images/member-1.png')}}" alt="">
        </div>
        <p>Alison Mina</p>
    </div>

    <div class="online-list">
        <div class="online">
            <img src="{{asset('storage/client/images/member-2.png')}}" alt="">
        </div>
        <p>Jackson Aston</p>
    </div>
    <div class="online-list">
        <div class="online">
            <img src="{{asset('storage/client/images/member-3.png')}}" alt="">
        </div>
        <p>Samona Rose</p>
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
        </script>
@endsection
