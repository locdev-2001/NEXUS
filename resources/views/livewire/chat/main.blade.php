<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('chat') }}
        </h2>
    </x-slot>
    <div class="chat_container">
        <div class="chat_list_container">
            @livewire('chat.chat-list')
        </div>
        <div class="chat_box_container">
            @livewire('chat.chatbox')
            @livewire('chat.send-message')
        </div>
    </div>
    <script>
        window.addEventListener('chatSeleted',event=>{
            $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight)
            let height = $('.chatbox_body')[0].scrollHeight
            window.livewire.emit('updateHeight',{
                height:height
            })
            $('.chat_box_container').show();
        })
        $(document).on('click', '.return', function() {
            $('.chat_box_container').hide();


        });
    </script>
</div>
