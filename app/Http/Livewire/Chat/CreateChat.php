<?php

namespace App\Http\Livewire\Chat;


use App\Models\Conversation;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class CreateChat extends Component
{
    public $user;
    public $message = 'Xin chào';
    public function checkConversation(Request $request){
        $recipientId = $request->input('id');
        $checkedConversation = Conversation::where('recipient_id',auth()->user()->id)->where('sender_id',$recipientId)
        ->orWhere('recipient_id',$recipientId)->where('sender_id',auth()->user()->id)->get();
        if (count($checkedConversation)==0){
//            dd(Carbon::now());
            $createdConversation = Conversation::create([
                'recipient_id'=>$recipientId,
                'sender_id'=>auth()->user()->id,
                'last_time_message'=>Carbon::now()
            ]);
            $createdMessage = Message::create([
                'conversation_id'=>$createdConversation->id,
                'sender_id'=>auth()->user()->id,
                'recipient_id'=>$recipientId,
                'body'=>$this->message
            ]);
            $createdConversation->last_time_message = $createdMessage->created_at;
            $createdConversation->save();
            return redirect()->route('messenger.chat');
        }
        else if(count($checkedConversation)>=1){
            return redirect()->route('messenger.chat');
        }
    }
    public function render()
    {
        return view('livewire.chat.create-chat');
    }
}
