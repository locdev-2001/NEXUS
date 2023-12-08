<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    @if($selectedConversation)
        <div class="chatbox_header">
            <div class="return">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
            <div class="img_container">
                <a href="/profile?id={{$receiverInstance->id}}">
                <img src="{{asset($receiverInstance->profile->avatar)}}" alt="">
                </a>
            </div>
            <div class="name fw-bold">
                <a class="hyper_link" href="/profile?id={{$receiverInstance->id}}">
                {{$receiverInstance->name}}
                </a>
            </div>
            <div class="info">
                <div class="info_item">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="info_item">
                    <i class="fa-solid fa-image"></i>
                </div>
                <div class="info_item">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
            </div>
        </div>
        <div class="chatbox_body">
            @foreach($messages as $message)
                <div wire:key="{{$message->id}}" class="msg_body {{auth()->id()==$message->sender_id? 'msg_body_me' : 'msg_body_receiver'}}" style="width: 80%; max-width: 80%;max-width: max-content">
                   {{$message->body}}
                    <div class="msg_body_footer">
                        <div class="date">
                            {{$message->created_at->format('H: i a')}}
                        </div>
                        <div class="read">
                            @php
                              if($message->user->id === auth()->id()){
                                    if ($message->read == 0){
                                        echo '<i class="fa-solid fa-check status-tick"></i>';
                                    }
                                    else{
                                        echo '<i class="fa-solid fa-check-double"></i>';
                                    }
                                }
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <script>
            $('.chatbox_body').scroll(function (){
                let top = $('.chatbox_body').scrollTop();
                if(top==0){
                    window.livewire.emit('loadmore')
                }
            })
            window.addEventListener('updatedHeight',event=>{
              let old = event.detail.height;
              let newHeight = $('.chatbox_body')[0].scrollHeight;
              let height = $('.chatbox_body').scrollTop(newHeight - old)
                window.livewire.emit('updateHeight',{
                    height:height
                })
            })
        </script>
    @else


        <div class="fs-4 text-center text-muted fw-bold mt-5 position-absolute"style="top:50%;left:50%; transform: translate(-50%,-50%)">
            Chào mừng bạn đến với <img class="w-25" src="{{asset('storage/client/images/logo/main-logo.png')}}">
        </div>
    @endif
    <script>
        window.addEventListener('rowChatToBottom',event=>{
            $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight)
        })
    </script>
    <script>
        $(document).on('click','.return',function(){
            window.livewire.emit('resetComponent')
        })
    </script>
    <script>
        window.addEventListener('markMessageAsRead',event=>{
            let value =  document.querySelectorAll('.status-tick');
            value.array.forEach(element,index=>{
                element.classList.remove('fa-solid fa-check');
                element.classList.add('fa-solid fa-check-double');
            })
        })
    </script>
</div>
