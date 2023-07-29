<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequests extends Model
{
    use HasFactory, HasTimestamps;
    protected $table = 'tgz_friend_requests';
    /**
     * The attributes that are mass assignable.
     * @var array<int,string>
     */
    protected $fillable=[
        'sender_id',
        'recipient_id',
        'status',
        'created_at',
        'updated_at'
    ];
}
