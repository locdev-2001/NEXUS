<?php

namespace App\Http\Controllers\client;

use App\Events\FriendRequestSent;
use App\Http\Controllers\Controller;
use App\Models\FriendRequests;
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
        event( new FriendRequestSent($senderId,$recipientId));
        return response()->json([
            'data' => $friendRequest
        ]);
    }

    private function setData($key, $value) {
        $this->_data[$key] = $value;
    }
}
