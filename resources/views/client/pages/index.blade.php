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
    <div class="new-feed">
    @foreach(json_decode($posts) as $post)
    <div class="status-field-container write-post-container">
        <div class="user-profile-box">
            <div class="user-profile">
                <img src="{{asset('storage/client/images/profile-pic.jpg')}}" alt="">
                <div>
                    <p>{{$post->user_name}}</p>
                    <small>{{$post->created_at}}</small>
                </div>
            </div>
            <div>
                <a href=""><i class="fas fa-ellipsis-v"></i></a>
            </div>
        </div>
        <div class="status-field">
            <div class="content">
                <span>{{$post->content_text}}</span>
            </div>
            <div class="status-img" id="si-{{$post->id}}">
{{--                @foreach($post->media_dir as $media)--}}
{{--                    <img src="{{asset('storage/'.$media)}}" alt="">--}}
{{--                @endforeach--}}
            </div>
        </div>
        <div class="statistics">
            <div class="reaction-statistics">
                @if(count($post->reactions)!==0)
                    <?php
                    $reactionRanks = App\Models\Post_reactions::where('post_id', $post->id)
                        ->select('reaction_type', DB::raw('COUNT(*) as count'))
                        ->groupBy('reaction_type')
                        ->orderBy('count','desc')
                        ->get(2);
                    ?>
                    <div class="reaction-counter">
                    @foreach($reactionRanks as $rank)
                        @if($rank->reaction_type ==1)
                                <img src="{{asset('storage/client/images/emoji/like.svg')}}" alt="like">
                            @elseif($rank->reaction_type ==2)
                                <img src="{{asset('storage/client/images/emoji/love.svg')}}" alt="love">
                            @elseif($rank->reaction_type ==3)
                                <img src="{{asset('storage/client/images/emoji/haha.svg')}}" alt="haha">
                            @elseif($rank->reaction_type ==4)
                                <img src="{{asset('storage/client/images/emoji/wow.svg')}}" alt="wow">
                            @elseif($rank->reaction_type ==5)
                                <img src="{{asset('storage/client/images/emoji/sad.svg')}}" alt="sad">
                            @else
                                <img src="{{asset('storage/client/images/emoji/angry.svg')}}" alt="angry">
                        @endif
                    @endforeach
                    </div>
                <span class="counter">{{count($post->reactions)}}</span>
                @endif
            </div>
            <div class="interacts">
                <div class="comment-counter"><span>123 bình luận</span></div>
                <div class="shared-counter"><span>1 lượt chia sẻ</span></div>
            </div>
        </div>
        <div class="post-reaction">
                <div class="reactions">
                    <div class="reaction-items" id="ri-{{$post->id}}">
                        @if(count($post->reactions) === 0)
                        <i class="fa-regular fa-thumbs-up"></i>&nbsp;<span class="reaction-type"> Thích</span>
                        @else
                                @php
                                    $userReaction = App\Models\Post_reactions::where('post_id',$post->id)->where('user_id',Auth::id())->first();
                                @endphp
                                @if($userReaction)
                                    @if($userReaction->reaction_type == 1)
                                        <img class="reaction-emoji" src="{{asset('storage/client/images/emoji/like.svg')}}" alt="">&nbsp;<span class="reaction-type like"> Thích</span>
                                    @elseif($userReaction->reaction_type == 2)
                                        <img class="reaction-emoji" src="{{asset('storage/client/images/emoji/love.svg')}}" alt="">&nbsp;<span class="reaction-type love"> Yêu thích</span>
                                    @elseif($userReaction->reaction_type == 3)
                                        <img class="reaction-emoji" src="{{asset('storage/client/images/emoji/haha.svg')}}" alt="">&nbsp;<span class="reaction-type haha"> Haha</span>
                                    @elseif($userReaction->reaction_type == 4)
                                        <img class="reaction-emoji" src="{{asset('storage/client/images/emoji/wow.svg')}}" alt="">&nbsp;<span class="reaction-type wow"> Wow</span>
                                    @elseif($userReaction->reaction_type == 5)
                                        <img class="reaction-emoji" src="{{asset('storage/client/images/emoji/sad.svg')}}" alt="">&nbsp;<span class="reaction-type sad"> Buồn</span>
                                    @else
                                        <img class="reaction-emoji" src="{{asset('storage/client/images/emoji/angry.svg')}}" alt="">&nbsp;<span class="reaction-type angry"> Phẫn nộ</span>
                                    @endif
                                @else
                                    <i class="fa-regular fa-thumbs-up"></i>&nbsp;<span class="reaction-type"> Thích</span>
                                @endif
                        @endif
                    </div>
                    <div class="wrap">
                        <div class="rect">
                            <img class="circle like" src="https://www.dropbox.com/s/rgfnea7od54xj4m/like.gif?raw=1" alt="like" title="Thích" data-type="1" data-p_id="{{$post->id}}">
                            <img class="circle love" src="https://www.dropbox.com/s/sykc43x39wqxlkz/love.gif?raw=1" alt="love" title="Yêu thích" data-type="2" data-p_id="{{$post->id}}">
                            <img class="circle haha" src="https://www.dropbox.com/s/vdg0a8i0kyd16zk/haha.gif?raw=1" alt="haha" title="Haha" data-type="3" data-p_id="{{$post->id}}">
                            <img class="circle wow" src="https://www.dropbox.com/s/ydl0fm5kayxz0e5/wow.gif?raw=1" alt="wow" title="Wow" data-type="4" data-p_id="{{$post->id}}">
                            <img class="circle sad" src="https://www.dropbox.com/s/52n5woibt3vrs76/sad.gif?raw=1" alt="sad" title="Buồn" data-type="5" data-p_id="{{$post->id}}">
                            <img class="circle angry" src="https://www.dropbox.com/s/kail2xnglbutusv/angry.gif?raw=1" alt="angry" title="Phẫn nộ" data-type="6" data-p_id="{{$post->id}}">
                        </div>
                    </div>
                </div>
                <div class="comments">
                    <div class="comments-btn" data-id ="{{$post->id}}">
                        <i class="fa-regular fa-message"></i>&nbsp;<span class="comment-tooltip"> Bình luận</span>
                    </div>
                </div>
                <div class="share">
                    <div class="share-btn">
                        <i class="fa-solid fa-share"></i>&nbsp;<span class="share-tooltip"> Chia sẻ</span>
                    </div>
                </div>
        </div>
        <div class="container">
            <div class="col-md-12 post-comment" id="post-comment-{{$post->id}}">
                <div class="body_comment align-items-center">
                    <div class="row">
                        <div class="avatar_comment col-md-1">
                            <img src="{{asset('storage/client/images/profile-pic.jpg')}}" alt="avatar"/>
                        </div>
                        <div class="box_comment col-md-11">
                            <textarea class="commentar" placeholder="Viết bình luận công khai..." data-id="{{$post->id}}"></textarea>
                            <div class="box_post">
                                <div class="pull-left d-flex justify-content-around col-2">
                                    <div class="upload-media extensions" data-id="{{$post->id}}">
                                        <i class="css-img" style="background-image: url({{asset('storage/client/images/icons/icon.png')}}); background-position: 0px -263px;"></i>
                                    </div>
                                    <div class="insert-emoji extensions" data-id="{{$post->id}}">
                                        <i class="css-img" style="background-image: url({{asset('storage/client/images/icons/icon.png')}}); background-position: 0px -314px;"></i>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <div class="submit extensions" data-id="{{$post->id}}"><i class="css-img" style="background-image: url({{asset('storage/client/images/icons/icon.png')}}); background-position: 0px -365px;"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <ul id="list_comment-{{$post->id}}" class="col-md-12 d-comment-box">
                            @foreach($post->comments as $comment)
                            <!-- Start List Comment 1 -->
                            <li class="box_result row">
                                <div class="avatar_comment col-md-1">
                                    <img src="{{asset('storage/client/images/profile-pic.jpg')}}" alt="avatar"/>
                                </div>
                                <div class="result_comment col-md-11">
                                    <h4>{{$comment->user_name}}</h4>
                                    <p>{{$comment->content}}</p>
                                    <div class="tools_comment d-flex justify-content-between">
                                        <div class="d-flex justify-content-between col-4">
                                            <a class="like" href="" data-r_id="{{$comment->id}}" data-p_id="{{$post->id}}">Thích</a>
                                            <a class="reply" href="" data-pr_id="{{$comment->id}}" data-p_id="{{$post->id}}">Phản hồi</a>
                                            <span>{{$comment->timeAgo}}</span>
                                        </div>
                                        <div class="d-flex col-6 justify-content-end">
                                            <i class="fa-solid fa-thumbs-up" style="color: #005eff;"></i> <span class="count">1</span>
                                        </div>
                                    </div>
                                    <ul class="child_reply">
                                        @foreach($comment->reply_comments as $reply)
                                        <li class="box_reply row">
                                            <div class="avatar_comment col-md-1">
                                                <img src="{{asset('storage/client/images/profile-pic.jpg')}}" alt="avatar"/>
                                            </div>
                                            <div class="result_comment col-md-11">
                                                    <h4>{{$reply->user_name}}</h4>
                                                <p>{{$reply->content}}</p>
                                                <div class="tools_comment d-flex justify-content-between">
                                                    <div class="d-flex justify-content-between col-4">
                                                        <a class="like" href="" data-pr_id="{{$reply->id}}" data-p_id="{{$post->id}}">Thích</a>
                                                        <a class="reply" href="" data-pr_id="{{$reply->id}}" data-p_id="{{$post->id}}">Phản hồi</a>
                                                        <span>{{$reply->timeAgo}}</span>
                                                    </div>
                                                    <div class="d-flex col-6 justify-content-end">
                                                        <i class="fa-solid fa-thumbs-up" style="color: #005eff;"></i> <span class="count">1</span>
                                                    </div>
                                                </div>
                                                <ul class="child_reply"></ul>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
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
            const postsData = {!! $posts !!};
            postsData.forEach((post) => {
                // Tạo một div mới cho mỗi bài viết
                const imageSources = post.media_dir.map(function(m){
                    m = "{{asset('storage')}}"+"/"+m
                    return m
                })
                const postId = post.id
                // Lặp qua các đường dẫn hình ảnh của bài viết và tạo các thẻ img tương ứng
                displayImageGrid(imageSources,postId)
            })
            function displayImageGrid(imgArr,postId){
                $("#si-"+postId).imagesGrid({
                        images:imgArr,
                        align: true,
                        cells:4,
                        getViewAllText: function (imagesCount) {
                            return "+" + imagesCount;
                        },
                    });
            }
        </script>
@endsection
