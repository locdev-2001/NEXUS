<?php

namespace App\Http\Controllers\client;

use App\Events\AcceptFriendRequest;
use App\Events\FriendRequestSent;
use App\Http\Controllers\Controller;
use App\Models\FriendRequests;
use App\Models\Friends;
use App\Models\Notification;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

class FriendController extends Controller
{
    //
    protected $_data = [];

    public function sendRequest(Request $request) {
        $senderId = Auth::id();
        $recipientId = $request->input('recipientID');
        $status = $request->input('status'); //1. thêm bạn 2.chấp nhận 3.từ chối

        // Kiểm tra và xử lý lỗi nếu giá trị không tồn tại
        if (empty($recipientId) || !in_array($status, [1, 2, 3])) {
            return response()->json(['error' => 'Giá trị không hợp lệ'], 400);
        }

        // Gán giá trị cho mảng $_data
        $param['sender_id'] = $senderId;
        $param['recipient_id'] = $recipientId;
        $param['status']=$status;

        // Tạo bản ghi mới và lưu vào cơ sở dữ liệu
        $friendRequest = FriendRequests::create($param);
        $sender = User::findOrFail($senderId);
        $senderProfile = Profile::where('user_id',$sender->id)->first();
        $data=[
            'avatar'=>$senderProfile->avatar,
            'hyper_link'=>'/profile?id='.$senderId,
            'senderId'=>$senderId,
            'message'=>$sender->name.' đã gửi cho bạn lời mời kết bạn',
            'action_text'=>'Chấp nhận',
            'action_url'=>route('client.accept.friend.request',['senderId'=>$senderId]),
            'reject_text'=>'Từ chối',
            'reject_url'=>route('client.reject.friend.request',['senderId'=>$senderId])
        ];
        event( new FriendRequestSent($senderId,$recipientId,$data));
        return response()->json([
            'data' => $friendRequest
        ]);
    }

    private function setData($key, $value) {
        $this->_data[$key] = $value;
    }
    public function reject(Request $request){
        $recipientId = Auth::id(); // người nhận là tôi
        $senderId = $request->input('senderId');
        FriendRequests::where('sender_id',$senderId)->where('recipient_id',$recipientId)->delete();
        Notification::where('sender_id',$senderId)->where('recipient_id',$recipientId)->where('type',1)->delete();
        return response()->json([
            'data'=>'success'
        ]);
    }
    public function accept(Request $request){
        $recipientId = Auth::id();//người nhận là tôi
        $senderId = $request->input('senderId');
        FriendRequests::where('sender_id',$senderId)->where('recipient_id',$recipientId)->delete();
        Notification::where('sender_id',$senderId)->where('recipient_id',$recipientId)->where('type',1)->delete();
        $param['user_id'] = $recipientId;
        $param['friend_id'] = $senderId;
        Friends::create($param);
        $sender = User::findOrFail($senderId);
        $profile = Profile::where('user_id',$recipientId)->first();
        $data=[
            'avatar'=>$profile->avatar,
            'hyper_link'=>'/profile?id='.$recipientId,
            'senderId'=>$recipientId,
            'message'=>Auth::user()->name.' đã chấp nhận lời mời kết bạn của bạn',
        ];
        Notification::create([
            'sender_id'=>$recipientId,
            'recipient_id'=>$senderId,
            'hyper_link'=>'/profile?id='.$recipientId,
            'data'=>json_encode($data),
            'type'=>2,// accept friend request
        ]);
        event( new AcceptFriendRequest($recipientId,$senderId,$data));
        return response()->json([
            'senderName' =>$sender->name,
            'hyper_link'=>'/profile?id='.$recipientId,
        ]);
    }
    public function unfriend(Request $request){
        $myId = Auth::id();
        $friendId= $request->input('f_id');
        $friend = Friends::where(function($query) use($myId, $friendId) {
            $query->where('user_id', $myId)
                ->where('friend_id', $friendId);
        })->orWhere(function($query) use($myId, $friendId) {
            $query->where('user_id', $friendId)
                ->where('friend_id', $myId);
        })->delete();
        return response()->json([
            'success'=>'thanh cong'
        ]);
    }
}
