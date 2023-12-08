@extends('client.pages.layout')
@section('main-content')
    <?php
    use App\Helpers\UserHelpers;
    $userHelpers = new UserHelpers();
    $authInf = $userHelpers->getUser();
    $authId = $userHelpers->getId();
    $friendRequest = $userHelpers::getFriendRequest($user->id);
    $isFriend = $userHelpers::isFriend($user->id);
    $profileInf = $userHelpers->getProfile();
    ?>
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
<div class="profile-container">
    <img src="{{asset($profile->cover)}}" class="coverImage" alt="">
    <div class="dashboard">
        <div class="left-dashboard">
            <img src="{{asset($profile->avatar)}}" class="dashboard-img" alt="">
            <div class="left-dashboard-info">
                <h1>{{$user->name}}</h1>
                <p>
                    <?php
                    $count = 0;
                    foreach($friends as $friend){
                        if ($friend->id !== $user->id){
                            $count++;
                        }
                    }
                    echo $count
                    ?>
                    bạn bè</p>
                <div class="mutual-friend-images">

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
                                   <a id="acceptBtn" href="/accept-friend-request?senderId={{$user->id}}"><button>Chấp nhận</button></a>
                                   <a id="rejectBtn" href="/reject-friend-request?senderId={{$user->id}}"><button>Từ chối</button></a>
                            @endif
                        @else
                            <button type="button" id="sendFriendRequest" data-user_id="{{$user->id}}" data-status="1"><i class="fas fa-user-plus"></i>Thêm bạn</button>
                        @endif

                        @elseif($isFriend === true)
                            <button id="friend-accepted"><i class="fa-solid fa-check"></i> Bạn bè</button>
                        <button id="unfriend" data-f_id="{{$user->id}}"><i class="fa-solid fa-xmark"></i> Hủy kết bạn</button>
                        @else
                    <button type="button" id="sendFriendRequest" data-user_id="{{$user->id}}" data-status="1"><i class="fas fa-user-plus"></i>Thêm bạn</button>
                    @endif
                    <a class="btn btn-light hyper_link fw-bold" href="/messenger/users?id={{$user->id}}" type="button"><i class="far fa-envelope"></i> Nhắn tin</a>
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
                <div class="avatar-options">
                <button type="button" class="edit-profile-btn hide" id="save-avatar">Lưu thay đổi</button>
                <button type="button" class="edit-profile-btn hide" id="edit-avatar">Chỉnh sửa</button>
                </div>
            </div>
            <div class="avatar-image" id="avatar-image">
                <img src="{{asset($profile->avatar)}}" class="avatar" alt="" id="avatar-preview">
                <input type="file" id="avatar-picture" class="">
            </div>
            <div class="modal fade" id="avatar-cropper" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tùy chỉnh hình ảnh <i class="fa-solid fa-crop-simple"></i> </h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" id="close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="img-container">
                                <div class="row">
                                    <div class="col-md-7">
                                        <img src="" id="sample_image" />
                                    </div>
                                    <div class="col-md-5">
                                        <div class="preview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="crop" class="btn btn-primary">Cắt</button>
                            <button type="button" class="btn btn-secondary" id="crop-cancel" data-dismiss="modal">Hủy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="component" id="cover-component">
            <div class="component-header">
                <h1>Ảnh bìa</h1>
                <div>
                <button type="button" class="edit-profile-btn edit-cover hide" id="save-cover">Lưu</button>
                <button type="button" class="edit-profile-btn edit-cover hide" id="cancel-cover">Hủy</button>
                </div>
            </div>
            <div class="cover-image" id="cover-image">
                <img src="{{asset($profile->cover)}}" class="cover" id="cover-preview" alt="">
                <input type="file" id="cover-picture" style="width: 100%" class="">
            </div>
        </div>
        <div class="component" id="bio-component">
            <div class="component-header">
                <h1>Giới thiệu</h1>
                <button type="button" class="edit-profile-btn edit-bio hide" id="save-bio">Lưu</button>
            </div>
            <div class="bio" id="bio-edit">
                <input type="text" id="bio-form" class="form-control" @if($profile->bio)value="{{$profile->bio}}@endif">
            </div>
        </div>
    </div>

    <div class="container-custom content-profile-container">
        <div class="left-sidebar profile-left-sidebar">
            <div class="left-profile-sidebar-top">
                <div class="intro-bio">
                    <h4>Giới thiệu</h4>
                    <p>@if($profile->bio){{$profile->bio}}@else Chưa cập nhật @endif</p>
                    <hr>
                </div>
            </div>

            <div class="left-profile-sidebar-top gallery">
                <div class="heading-link profile-heading-link">
                    <h4>Ảnh</h4>
                </div>

                <div class="gallery-photos">
                    <div class="gallery-photos-rowFirst" id="personal-gallery">

                    </div>
                </div>
            </div>

            <div class="left-profile-sidebar-top gallery">
                <div class="heading-link profile-heading-link">
                    <h4>Bạn bè</h4>
                </div>
                <div class="gallery-photos">
                    <div class="gallery-photos-rowFirst">
                        @foreach($friends as $friend)
                            @if($friend->id !== $user->id)
                            <div class="first-friend">
                                <a href="/profile?id={{$friend->id}}" class="hyper_link">
                                    <img src="{{asset($friend->profile->avatar)}}" alt="">
                                    <p>{{$friend->name}}</p>
                                </a>
                             </div>
                            @endif
                        @endforeach
{{--                        <div class="second-friend">--}}
{{--                            <img src="{{asset('storage/client/images/member-2.png')}}" alt="">--}}
{{--                            <p>Joseph N</p>--}}
{{--                        </div>--}}
{{--                        <div class="third-friend">--}}
{{--                            <img src="{{asset('storage/client/images/member-3.png')}}" alt="">--}}
{{--                            <p>Blondie K</p>--}}
{{--                        </div>--}}
{{--                        <div class="forth-friend">--}}
{{--                            <img src="{{asset('storage/client/images/member-4.png')}}" alt="">--}}
{{--                            <p>Jonathon J</p>--}}
{{--                        </div>--}}
{{--                        <div class="fifth-friend">--}}
{{--                            <img src="{{asset('storage/client/images/member-5.png')}}" alt="">--}}
{{--                            <p>Mark K</p>--}}
{{--                        </div>--}}
{{--                        <div class="sixth-friend">--}}
{{--                            <img src="{{asset('storage/client/images/member-6.png')}}" alt="">--}}
{{--                            <p>Emilia M</p>--}}
{{--                        </div>--}}
{{--                        <div class="seventh-friend">--}}
{{--                            <img src="{{asset('storage/client/images/member-7.png')}}" alt="">--}}
{{--                            <p>Max P</p>--}}
{{--                        </div>--}}
{{--                        <div class="eighth-friend">--}}
{{--                            <img src="{{asset('storage/client/images/member-8.png')}}" alt="">--}}
{{--                            <p>Layla M</p>--}}
{{--                        </div>--}}
{{--                        <div class="ninth-friend">--}}
{{--                            <img src="{{asset('storage/client/images/member-9.png')}}" alt="">--}}
{{--                            <p>Edward M</p>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>

        </div>

        <!-- main-content------- -->

        <div class="content-area profile-content-area">
            @if(UserHelpers::getId() == $user->id)
            <div class="write-post-container">
                <div class="user-profile" style="padding: 10px">
                    <a href="/profile?id={{UserHelpers::getId()}}"><img src="{{asset($profile->avatar)}}"></a>
                    <div class="timeline_nexus">
                        <a class="modaal-popup" href="#post-upload"><span class="input000">Bạn đang nghĩ gì thế, {{$authInf->name}} ?</span></a>
                    </div>
                </div>
            </div>
            <div class="write-post-container" id="post-upload" style="display: none">
                <form action="{{route('client.createPost')}}" method="POST" enctype="multipart/form-data" id="nexus_timeline">
                    @csrf
                    <div class="user-profile">
                        <a href="/profile?id={{UserHelpers::getId()}}"><img src="{{asset($profile->avatar)}}" alt=""></a>
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
            @endif
            @foreach(json_decode($posts) as $post)
            @if($post->post_mode ==3)
                @if($post->user_id == $authId)
                    <div class="status-field-container write-post-container">
                <div class="user-profile-box">
                    <div class="user-profile">
                        <img src="{{asset($profile->avatar)}}" alt="">
                        <div>
                            <p>{{$post->user_name}}</p>
                            <div class="post_mode_cfg" data-mode="{{$post->post_mode}}">
                                <small class="f-a post_mode">@if($post->post_mode==1) Công khai &#xf57e @elseif($post->post_mode == 2) Bạn bè &#xf500 @else Chỉ mình tôi &#xf023 @endif</small>
                                <small class="f-a post_mode">@if($post->active==0) Đợi duyệt @elseif($post->active == 1) Đã duyệt @else Đã bị khóa @endif</small>
                            </div>
                            <small>{{$post->created_at}}</small>
                        </div>
                    </div>
                    <div>
                        @if($post->user_id == $authId)
                        <a href="" class="edit-post-btn"><i class="fas fa-ellipsis-v"></i></a>
                        <div class="option-box hide">
                            <div class="edit-post-box w-25">
                                <span class="tool-box edit-post" data-id="{{$post->id}}"><i class="fa-solid fa-pen"></i> Chỉnh sửa</span>
                                <span class="tool-box remove-post" data-id="{{$post->id}}"><i class="fa-solid fa-trash"></i> Xóa</span>
                                <div class="dialog-confirm hide">
                                    <span>Bạn chắc chắn muốn xóa chứ ?</span>
                                    <div class="d-flex justify-content-around">
                                        <button class="btn confirm"><i class="fa-solid fa-check" style="color: #00ff2a;"></i></button>
                                        <button class="btn deny"><i class="fa-solid fa-x" style="color: #ff0000;"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="status-field">
                    <div class="content">
                        <span>{{$post->content_text}}</span>
                    </div>
                    @foreach($post->media_dir as $media_dir)
                        <input type="hidden" class="hidden-image" value="{{asset('storage/'.$media_dir)}}">
                    @endforeach
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
                        <div class="comment-counter"><span>{{$post->countComment}} bình luận</span></div>
                        <div class="shared-counter"><span></span></div>
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
                                <img class="circle like" src="{{asset('storage/client/images/emoji/like.gif')}}" alt="like" title="Thích" data-type="1" data-p_id="{{$post->id}}">
                                <img class="circle love" src="{{asset('storage/client/images/emoji/love.gif')}}" alt="love" title="Yêu thích" data-type="2" data-p_id="{{$post->id}}">
                                <img class="circle haha" src="{{asset('storage/client/images/emoji/haha.gif')}}" alt="haha" title="Haha" data-type="3" data-p_id="{{$post->id}}">
                                <img class="circle wow" src="{{asset('storage/client/images/emoji/wow.gif')}}" alt="wow" title="Wow" data-type="4" data-p_id="{{$post->id}}">
                                <img class="circle sad" src="{{asset('storage/client/images/emoji/sad.gif')}}" alt="sad" title="Buồn" data-type="5" data-p_id="{{$post->id}}">
                                <img class="circle angry" src="{{asset('storage/client/images/emoji/angry.gif')}}" alt="angry" title="Phẫn nộ" data-type="6" data-p_id="{{$post->id}}">
                            </div>
                        </div>
                    </div>
                    <div class="comments">
                        <div class="comments-btn" data-id ="{{$post->id}}">
                            <i class="fa-regular fa-message"></i>&nbsp;<span class="comment-tooltip"> Bình luận</span>
                        </div>
                    </div>
                    <div class="share">
                        <div class="share-btn" onclick="copyToClipboard('{{url('/post?id=').$post->id}}')">
                            <i class="fa-solid fa-share"></i>&nbsp;<span class="share-tooltip"> Chia sẻ</span>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="col-md-12 post-comment" id="post-comment-{{$post->id}}">
                        <div class="body_comment align-items-center">
                            <div class="row">
                                <div class="avatar_comment col-md-1">
                                    <img src="{{asset($profileInf->avatar)}}" alt="avatar"/>
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
                                                <img src="{{asset($comment->user_avatar)}}" alt="avatar"/>
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
                                                        @include('client.pages.comments_partials',['reply'=>$reply])
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
                @endif
            @elseif($post->post_mode == 2)
                @if($post->user_id == $authId || $userHelpers->isFriend($post->user_id))
                    <div class="status-field-container write-post-container">
                        <div class="user-profile-box">
                            <div class="user-profile">
                                <img src="{{asset($profile->avatar)}}" alt="">
                                <div>
                                    <p>{{$post->user_name}}</p>
                                    <div class="post_mode_cfg" data-mode="{{$post->post_mode}}">
                                        <small class="f-a post_mode">@if($post->post_mode==1) Công khai &#xf57e @elseif($post->post_mode == 2) Bạn bè &#xf500 @else Chỉ mình tôi &#xf023 @endif</small>
                                        <small class="f-a post_mode">@if($post->active==0) Đợi duyệt @elseif($post->active == 1) Đã duyệt @else Đã bị khóa @endif</small>
                                    </div>
                                    <small>{{$post->created_at}}</small>
                                </div>
                            </div>
                            <div>
                                @if($post->user_id == $authId)
                                    <a href="" class="edit-post-btn"><i class="fas fa-ellipsis-v"></i></a>
                                    <div class="option-box hide">
                                        <div class="edit-post-box w-25">
                                            <span class="tool-box edit-post" data-id="{{$post->id}}"><i class="fa-solid fa-pen"></i> Chỉnh sửa</span>
                                            <span class="tool-box remove-post" data-id="{{$post->id}}"><i class="fa-solid fa-trash"></i> Xóa</span>
                                            <div class="dialog-confirm hide">
                                                <span>Bạn chắc chắn muốn xóa chứ ?</span>
                                                <div class="d-flex justify-content-around">
                                                    <button class="btn confirm"><i class="fa-solid fa-check" style="color: #00ff2a;"></i></button>
                                                    <button class="btn deny"><i class="fa-solid fa-x" style="color: #ff0000;"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="status-field">
                            <div class="content">
                                <span>{{$post->content_text}}</span>
                            </div>
                            @foreach($post->media_dir as $media_dir)
                                <input type="hidden" class="hidden-image" value="{{asset('storage/'.$media_dir)}}">
                            @endforeach
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
                                <div class="comment-counter"><span>{{$post->countComment}} bình luận</span></div>
                                <div class="shared-counter"><span></span></div>
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
                                        <img class="circle like" src="{{asset('storage/client/images/emoji/like.gif')}}" alt="like" title="Thích" data-type="1" data-p_id="{{$post->id}}">
                                        <img class="circle love" src="{{asset('storage/client/images/emoji/love.gif')}}" alt="love" title="Yêu thích" data-type="2" data-p_id="{{$post->id}}">
                                        <img class="circle haha" src="{{asset('storage/client/images/emoji/haha.gif')}}" alt="haha" title="Haha" data-type="3" data-p_id="{{$post->id}}">
                                        <img class="circle wow" src="{{asset('storage/client/images/emoji/wow.gif')}}" alt="wow" title="Wow" data-type="4" data-p_id="{{$post->id}}">
                                        <img class="circle sad" src="{{asset('storage/client/images/emoji/sad.gif')}}" alt="sad" title="Buồn" data-type="5" data-p_id="{{$post->id}}">
                                        <img class="circle angry" src="{{asset('storage/client/images/emoji/angry.gif')}}" alt="angry" title="Phẫn nộ" data-type="6" data-p_id="{{$post->id}}">
                                    </div>
                                </div>
                            </div>
                            <div class="comments">
                                <div class="comments-btn" data-id ="{{$post->id}}">
                                    <i class="fa-regular fa-message"></i>&nbsp;<span class="comment-tooltip"> Bình luận</span>
                                </div>
                            </div>
                            <div class="share">
                                <div class="share-btn" onclick="copyToClipboard('{{url('/post?id=').$post->id}}')">
                                    <i class="fa-solid fa-share"></i>&nbsp;<span class="share-tooltip"> Chia sẻ</span>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="col-md-12 post-comment" id="post-comment-{{$post->id}}">
                                <div class="body_comment align-items-center">
                                    <div class="row">
                                        <div class="avatar_comment col-md-1">
                                            <img src="{{asset($profileInf->avatar)}}" alt="avatar"/>
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
                                                        <img src="{{asset($comment->user_avatar)}}" alt="avatar"/>
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
                                                                @include('client.pages.comments_partials',['reply'=>$reply])
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
                @endif
            @else
                        <div class="status-field-container write-post-container">
                            <div class="user-profile-box">
                                <div class="user-profile">
                                    <img src="{{asset($profile->avatar)}}" alt="">
                                    <div>
                                        <p>{{$post->user_name}}</p>
                                        <div class="post_mode_cfg" data-mode="{{$post->post_mode}}">
                                            <small class="f-a post_mode">@if($post->post_mode==1) Công khai &#xf57e @elseif($post->post_mode == 2) Bạn bè &#xf500 @else Chỉ mình tôi &#xf023 @endif</small>
                                            @if($post->user_id == $authId)<small class="f-a post_mode">@if($post->active==0) Đợi duyệt @elseif($post->active == 1) Đã duyệt @else Đã bị khóa @endif</small>@endif
                                        </div>
                                        <small>{{$post->created_at}}</small>
                                    </div>
                                </div>
                                <div>
                                    @if($post->user_id == $authId)
                                        <a href="" class="edit-post-btn"><i class="fas fa-ellipsis-v"></i></a>
                                        <div class="option-box hide">
                                            <div class="edit-post-box w-25">
                                                <span class="tool-box edit-post" data-id="{{$post->id}}"><i class="fa-solid fa-pen"></i> Chỉnh sửa</span>
                                                <span class="tool-box remove-post" data-id="{{$post->id}}"><i class="fa-solid fa-trash"></i> Xóa</span>
                                                <div class="dialog-confirm hide">
                                                    <span>Bạn chắc chắn muốn xóa chứ ?</span>
                                                    <div class="d-flex justify-content-around">
                                                        <button class="btn confirm"><i class="fa-solid fa-check" style="color: #00ff2a;"></i></button>
                                                        <button class="btn deny"><i class="fa-solid fa-x" style="color: #ff0000;"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="status-field">
                                <div class="content">
                                    <span>{{$post->content_text}}</span>
                                </div>
                                @foreach($post->media_dir as $media_dir)
                                    <input type="hidden" class="hidden-image" value="{{asset('storage/'.$media_dir)}}">
                                @endforeach
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
                                    <div class="comment-counter"><span>{{$post->countComment}} bình luận</span></div>
                                    <div class="shared-counter"><span></span></div>
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
                                            <img class="circle like" src="{{asset('storage/client/images/emoji/like.gif')}}" alt="like" title="Thích" data-type="1" data-p_id="{{$post->id}}">
                                            <img class="circle love" src="{{asset('storage/client/images/emoji/love.gif')}}" alt="love" title="Yêu thích" data-type="2" data-p_id="{{$post->id}}">
                                            <img class="circle haha" src="{{asset('storage/client/images/emoji/haha.gif')}}" alt="haha" title="Haha" data-type="3" data-p_id="{{$post->id}}">
                                            <img class="circle wow" src="{{asset('storage/client/images/emoji/wow.gif')}}" alt="wow" title="Wow" data-type="4" data-p_id="{{$post->id}}">
                                            <img class="circle sad" src="{{asset('storage/client/images/emoji/sad.gif')}}" alt="sad" title="Buồn" data-type="5" data-p_id="{{$post->id}}">
                                            <img class="circle angry" src="{{asset('storage/client/images/emoji/angry.gif')}}" alt="angry" title="Phẫn nộ" data-type="6" data-p_id="{{$post->id}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="comments">
                                    <div class="comments-btn" data-id ="{{$post->id}}">
                                        <i class="fa-regular fa-message"></i>&nbsp;<span class="comment-tooltip"> Bình luận</span>
                                    </div>
                                </div>
                                <div class="share">
                                    <div class="share-btn" onclick="copyToClipboard('{{url('/post?id=').$post->id}}')">
                                        <i class="fa-solid fa-share"></i>&nbsp;<span class="share-tooltip"> Chia sẻ</span>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="col-md-12 post-comment" id="post-comment-{{$post->id}}">
                                    <div class="body_comment align-items-center">
                                        <div class="row">
                                            <div class="avatar_comment col-md-1">
                                                <img src="{{asset($profileInf->avatar)}}" alt="avatar"/>
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
                                                            <img src="{{asset($comment->user_avatar)}}" alt="avatar"/>
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
                                                                    @include('client.pages.comments_partials',['reply'=>$reply])
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
            @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('script-bottom')
    <script src="https://unpkg.com/cropperjs"></script>
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
        const media = {!! json_encode($media) !!};
        let assetMediaArr = media.map(function(path) {
            return "{{asset('storage')}}" + '/' + path;
        });
            $('#personal-gallery').imagesGrid({
                images:assetMediaArr,
                align:true,
                cells:6,
                getViewAllText: function (imagesCount) {
                    return "+" + imagesCount;
                }}
            )
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
        function copyToClipboard(text) {
            const input = document.createElement('input');
            input.value = text;
            input.setAttribute('readonly', '');
            input.style.position = 'absolute';
            input.style.left = '-9999px';
            document.body.appendChild(input);
            const selected =
                document.getSelection().rangeCount > 0 ? document.getSelection().getRangeAt(0) : false;
            input.select();
            console.log(input.value)
            document.execCommand('copy');
            document.body.removeChild(input);
            if (selected) {
                document.getSelection().removeAllRanges();
                document.getSelection().addRange(selected);
            }
            $.toast({
                heading: 'Copy To Clipboard',
                text: 'Đã copy vào khay nhớ tạm',
                showHideTransition: 'slide',
                icon: 'success',
                position: 'top-right',
            })
        }
        $('#unfriend').on('click',function(){
            let f_id = $(this).data('f_id');
            console.log(f_id)
            $.ajax({
                url:'/unfriend',
                type:"POST",
                headers:{
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                },
                data:{
                    f_id:f_id
                },
                success:function(res){
                    window.location.reload()
                }
            })
        })
        $('#acceptBtn').on('click',function(e){
            e.preventDefault();
            let action = $(this).attr('href');
            jQuery.ajax({
                url:action,
                headers:{
                    'X-CSRF-TOKEN':'{{csrf_token()}}'
                },
                success:function(res){
                    window.location.reload()
                }
            })
        })
        $('#rejectBtn').on('click',function(e){
            e.preventDefault();
            let action = $(this).attr('href');
            jQuery.ajax({
                url:action,
                headers:{
                    'X-CSRF-TOKEN':'{{csrf_token()}}'
                },
                success:function(res){
                    window.location.reload()
                }
            })
        })
    </script>
    <script src="{{asset('storage/client/js/cropper.js')}}"></script>
@endsection
