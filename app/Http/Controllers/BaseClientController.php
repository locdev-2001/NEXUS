<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class BaseClientController extends Controller
{
    //
    public function getTimeAgoAtrr($t){
        $created_at = Carbon::parse($t);
        $now = Carbon::now();
        $diff = $created_at->diff($now);
        if($diff->days >=365 ){
            $years = floor($diff->days / 365);
            return $years .' năm trước';
        }
        elseif ($diff->days >= 3) {
            return $created_at->format('d \t\h\á\n\g m');
        }
        elseif ($diff->days >= 1) {
            return $diff->days . ' ngày trước';
        }
        elseif ($diff->h >=1) {
            return $diff->format('%h giờ trước');
        }
        elseif($diff->i >=1){
            return $diff->i .' phút trước';
        }
        else{
            return 'Vừa xong';
        }
    }
    public function buildNestedComments($comments, $parent_id = null) {
        $nestedComments = [];
        foreach ($comments as $comment) {
            if ($comment['parent_id'] === $parent_id) {
                $comment['timeAgo'] = $this->getTimeAgoAtrr($comment['created_at']);
                $comment['user_name'] = $comment['user']['name'];
                $comment['user_avatar'] = $comment['user']['profile']['avatar'];
                $comment['reply_comments'] = $this->buildNestedComments($comments, $comment['id']);
                $nestedComments[] = $comment;
            }
        }
        return $nestedComments;
    }
    public function f_info_buffer($data){
        $f_info = finfo_open();
        $mimeType =finfo_buffer($f_info,$data,FILEINFO_MIME_TYPE);
        finfo_close($f_info);
        $extension = '';
        if ($mimeType === 'image/jpeg') {
            $extension = 'jpg';
        } elseif ($mimeType === 'image/png') {
            $extension = 'png';
        } elseif ($mimeType === 'image/gif') {
            $extension = 'gif';
        }
        return $extension;
    }
}
