<li class="box_reply row" id="cmt-{{$reply->id}}">
    <div class="avatar_comment col-md-1">
        <img src="{{asset($reply->user_avatar)}}" alt="avatar"/>
    </div>
    <div class="result_comment col-md-11">
        <h4>{{$reply->user_name}}</h4>
        <p>{{$reply->content}}</p>
        <div class="tools_comment d-flex justify-content-between">
            <div class="d-flex justify-content-between col-5">
                @php
                    $userHasLikedComment = false;
                    if(!empty($post->reaction_comment)) {
                        foreach($post->reaction_comment as $reaction_comment) {
                            if($reaction_comment->user_id == $authId && $reaction_comment->post_id == $post->id && $reaction_comment->comment_id == $reply->id) {
                                $userHasLikedComment = true;
                                break;
                            }
                        }
                    }
                @endphp

                @if($userHasLikedComment)
                    <a class="like" href="" data-r_id="{{$reply->id}}" data-p_id="{{$post->id}}">Thích <i class="fa-solid fa-thumbs-up" style="color: #005eff;"></i></a>
                @else
                    <a class="like" href="" data-r_id="{{$reply->id}}" data-p_id="{{$post->id}}">Thích</a>
                @endif
                <a class="reply" href="" data-pr_id="{{$reply->id}}" data-p_id="{{$post->id}}">Phản hồi</a>
                <span>{{$reply->timeAgo}}</span>
            </div>
            <div class="d-flex col-6 justify-content-end">
                <i class="fa-solid fa-thumbs-up" style="color: #005eff;"></i> <span class="count" id="c-{{$reply->id}}">&nbsp;
                    @php
                        $count = 0;
                        foreach ($post->reaction_comment as $reaction_comment){
                            if ($reaction_comment->post_id == $post->id && $reaction_comment->comment_id == $reply->id){
                                $count++;
                            }
                        }
                        echo $count;
                    @endphp
                </span>
            </div>
        </div>
        <ul class="child_reply">
            @foreach($reply->reply_comments as $nested_reply)
                @include('client.pages.comments_partials',['reply'=>$nested_reply])
            @endforeach
        </ul>
    </div>
</li>
