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
        if ($diff->days >= 3) {
            return $created_at->format('d \t\h\á\n\g m \n\ă\m Y');
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
                $comment['reply_comments'] = $this->buildNestedComments($comments, $comment['id']);
                $nestedComments[] = $comment;
            }
        }
        return $nestedComments;
    }

}
