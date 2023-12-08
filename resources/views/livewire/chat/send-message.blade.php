<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @if($selectedConversation)
        <form wire:submit.prevent="sendMessage" action="">
            <div class="chatbox_footer">
                <div class="custom_form_group">
                    <input wire:model="body" type="text" class="form-control control" placeholder="Nhập tin nhắn">
                    <button type="submit" class="btn submit"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </div>
        </form>
    @endif
</div>
