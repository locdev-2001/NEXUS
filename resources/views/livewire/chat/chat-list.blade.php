<div>
    {{-- In work, do what you enjoy. --}}
    <audio id="myAudio">
        <source src="{{ asset('storage/client/audio/notifications.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <div class="chatlist_header">
        <div class="title">
            Đoạn chat
        </div>
        <div class="img_container">
            <a href="/profile?id={{auth()->id()}}">
            <img src="{{asset($profile->avatar)}}" alt="">
            </a>
        </div>
    </div>
    <div class="chatlist_body">
        @if(count($conversations) > 0)
            @foreach($conversations as $conversation)
            <div class="chatlist_item" wire:key="{{$conversation->id}}" wire:click="$emit('chatUserSelected',{{$conversation}},{{$this->getChatUserInstance($conversation, $name = 'id')}})">
                <div class="chatlist_img_container">
                    <img src="{{asset($this->getChatUserInstance($conversation,$name = 'profile')->avatar)}}" alt="">
                </div>
                <div class="chatlist_info">
                    <div class="top_row">
                        <div class="list_username fw-bold">
                            {{$this->getChatUserInstance($conversation,$name = 'name')}}
                        </div>
                        <?php
                        $timediff = App\Helpers\UserHelpers::getTimeAgoAtrr($conversation->messages->last()->created_at)
                        ?>
                        <span class="date">{{$timediff}}</span>
                    </div>
                    <div class="bottom_row">
                        <div class="message_body text-truncate @if($conversation->messages->last()->sender_id !== auth()->id()) message_to_me @endif">
                            @if($conversation->messages->last()->sender_id == auth()->id())
                                Bạn:
                            @endif
                            {{$conversation->messages->last()->body}}
                        </div>
                        @php
                            if (count($conversation->messages->where('read',0)->where('recipient_id',Auth()->user()->id))){
                                echo '<div class="unread_count badge rounded-pill text-light bg-danger">'.count($conversation->messages->where('read',0)->where('recipient_id',Auth()->user()->id)).' </div>';
                            }
                        @endphp
                    </div>
                </div>
            </div>
            @endforeach
        @else
            Không có đoạn hội thoại nào để hiển thị
        @endif
    </div>
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.hook('element.updated', (el, component) => {
                if(el.className.includes('message_to_me')){
                    let audio = document.getElementById('myAudio');
                    audio.play();
                }
            });
        });
    </script>
</div>
