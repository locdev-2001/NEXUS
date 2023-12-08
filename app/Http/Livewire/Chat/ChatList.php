<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Profile;
use App\Models\User;
use Livewire\Component;

class ChatList extends Component
{
    public $auth_id;
    public $conversations;
    public $recipientInstance;
    public $name;
    public $selectedConversation;
    public $profile;
    protected $listeners = ['chatUserSelected','refresh'=>'$refresh','resetComponent'];
    public function resetComponent()
    {
        $this->selectedConversation = null;
        $this->recipientInstance=null;
    }

    public function chatUserSelected(Conversation $conversation,$recipientId){
        $this->selectedConversation = $conversation;
        $receiverInstance = User::with('profile')->findOrFail($recipientId);
        $this->emitTo('chat.chatbox','loadConversation', $this->selectedConversation, $receiverInstance);
        $this->emitTo('chat.send-message','updateSendMessage',$this->selectedConversation, $receiverInstance);
    }
    public function getChatUserInstance(Conversation $conversation,$request){
        $this->auth_id = auth()->id();
        //get selected conversation
        if($conversation->sender_id == $this->auth_id){
            $this->recipientInstance = User::with('profile')->where('id',$conversation->recipient_id)->first();
        }
        else{
            $this->recipientInstance = User::with('profile')->where('id',$conversation->sender_id)->first();
        }
        if (isset($request)){
            return $this->recipientInstance->$request;

        }
    }
    public function mount(){
        $this->auth_id = auth()->id();
        $this->conversations = Conversation::where('sender_id',$this->auth_id)
            ->orWhere('recipient_id',$this->auth_id)->orderBy('last_time_message','DESC')->get();
        $this->profile = Profile::where('user_id',auth()->id())->first();
    }
    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}
