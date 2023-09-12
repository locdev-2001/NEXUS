@extends('client.pages.layout')
@section('main-content')
    <?php
    use App\Helpers\UserHelpers;
    $userHelpers = new UserHelpers();
    $authInf = $userHelpers->getUser();
    $authId = $userHelpers->getId();
    $authProfile = $userHelpers->getProfile();
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
    <div class="content-area">
    <div class="new-feed">
    <div class="status-field-container write-post-container" id="p-{{$post->id}}">
        <div class="user-profile-box">
            <div class="user-profile">
                <img src="{{asset($post->user_avatar)}}" alt="">
                <div>
                    <p>{{$post->user_name}}</p>
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
            <div class="col-md-12 post-comment toggle-comment" id="post-comment-{{$post->id}}">
                <div class="body_comment align-items-center">
                    <div class="row">
                        <div class="avatar_comment col-md-1">
                            <img src="{{asset($post->user_avatar)}}" alt="avatar"/>
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
                                <li class="box_result row" id="cmt-{{$comment->id}}">
                                    <div class="avatar_comment col-md-1">
                                        <img src="{{asset($comment->user_avatar)}}" alt="avatar"/>
                                    </div>
                                    <div class="result_comment col-md-11">
                                        <h4>{{$comment->user_name}}</h4>
                                        <p>{{$comment->content}}</p>
                                        <div class="tools_comment d-flex justify-content-between">
                                            <div class="d-flex justify-content-between col-4">
                                                @php
                                                    $userHasLikedComment = false;
                                                    if(!empty($post->reaction_comment)) {
                                                        foreach($post->reaction_comment as $reaction_comment) {
                                                            if($reaction_comment->user_id == $authId && $reaction_comment->post_id == $post->id && $reaction_comment->comment_id == $comment->id) {
                                                                $userHasLikedComment = true;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                @endphp

                                                @if($userHasLikedComment)
                                                    <a class="like" href="" data-r_id="{{$comment->id}}" data-p_id="{{$post->id}}">Thích <i class="fa-solid fa-thumbs-up" style="color: #005eff;"></i></a>
                                                @else
                                                    <a class="like" href="" data-r_id="{{$comment->id}}" data-p_id="{{$post->id}}">Thích</a>
                                                @endif
                                                <a class="reply" href="" data-pr_id="{{$comment->id}}" data-p_id="{{$post->id}}">Phản hồi</a>
                                                <span>{{$comment->timeAgo}}</span>
                                            </div>
                                            <div class="d-flex col-6 justify-content-end">
                                                <i class="fa-solid fa-thumbs-up" style="color: #005eff;"></i><span class="count" id="c-{{$comment->id}}">&nbsp;
                                                    @php
                                                        $count = 0;
                                                        foreach ($post->reaction_comment as $reaction_comment){
                                                            if ($reaction_comment->post_id == $post->id && $reaction_comment->comment_id == $comment->id){
                                                                $count++;
                                                            }
                                                        }
                                                        echo $count;
                                                    @endphp
                                                </span>
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
    </div>
    </div>
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

        function updateImagesGrid(arrImg){
            $('#gallery').imagesGrid({
                images: arrImg,
                align:true,
                getViewAllText: function(imagesCount) {
                    return '+' + imagesCount;
                }
            })
        }
        const postsData = {!! json_encode($post) !!};

            // Tạo một div mới cho mỗi bài viết
        const imageSources = postsData.media_dir.map(function(m){
            m = "{{asset('storage')}}"+"/"+m
            return m
        })
        const postId = postsData.id
        // Lặp qua các đường dẫn hình ảnh của bài viết và tạo các thẻ img tương ứng
        displayImageGrid(imageSources,postId)

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
    </script>
@endsection
