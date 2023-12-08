<?php

namespace App\Http\Livewire\Chat;

use App\Events\MessageRead;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class Chatbox extends Component
{
    public $selectedConversation;
    public $receiverInstance;
    public $messages;
    public $messages_count;
    public $paginateVar = 10;
    public $height;
//    protected $listeners=['loadConversation','pushMessage','loadmore','updateHeight'];
    public function getListeners(){
        $authId= auth()->id();
        return[
          "echo-private:chat.{$authId},MessageSent"=>"broadcastedMessageReceived",
            "echo-private:chat.{$authId},MessageRead"=>"broadcastedMessageRead",
            'loadConversation','pushMessage','loadmore','updateHeight','broadcastMessageRead','resetComponent'
        ];
    }
    public function resetComponent()
    {
        $this->selectedConversation = null;
        $this->receiverInstance=null;
    }

    public function broadcastedMessageRead($event){
        if ($this->selectedConversation){
            if ((int) $this->selectedConversation->id === (int) $event['conversation_id']){
                $this->dispatchBrowserEvent('markMessageAsRead');
            }
        }
    }
    public function broadcastedMessageReceived($event){
        $this->emitTo('chat.chat-list','refresh');
        $broadCastedMessage = Message::find($event['message']);
        if($this->selectedConversation){
            if((int) $this->selectedConversation->id === (int)$event['conversation_id']){
               $broadCastedMessage->read = 1;
               $broadCastedMessage->save();
               $this->pushMessage($broadCastedMessage->id);
               $this->emitSelf('broadcastMessageRead');
            }
        }
    }
    public function broadcastMessageRead(){
        broadcast( new MessageRead($this->selectedConversation->id,$this->receiverInstance->id));
    }
    public function pushMessage($messageId){
        $newMessage = Message::find($messageId);
        $this->messages->push($newMessage);
        $this->dispatchBrowserEvent('rowChatToBottom');
    }
    public function loadmore(){
        $this->paginateVar = $this->paginateVar+10;
        $this->messages_count = Message::where('conversation_id',$this->selectedConversation->id)->count();
        $this->messages = Message::where('conversation_id',$this->selectedConversation->id)->skip($this->messages_count - $this->paginateVar)->take($this->paginateVar)->get();
        $height = $this->height;
        $this->dispatchBrowserEvent('updatedHeight',($height));
    }
    public function updateHeight($height){
        $this->height = $height;
    }
    public function loadConversation(Conversation $conversation, User $recipient){
        $receiver = User::with('profile')->findOrFail($recipient->id);
        $this->selectedConversation = $conversation;
        $this->receiverInstance = $receiver;
        $this->messages_count = Message::where('conversation_id',$this->selectedConversation->id)->count();
        $this->messages = Message::where('conversation_id',$this->selectedConversation->id)->skip($this->messages_count - $this->paginateVar)->take($this->paginateVar)->get();
        $this->dispatchBrowserEvent('chatSeleted');
        Message::where('conversation_id',$this->selectedConversation->id)->where('recipient_id',auth()->id())->update(['read'=>1]);
        $this->emitSelf('broadcastMessageRead');
    }
    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
