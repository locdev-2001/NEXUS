<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory,HasTimestamps;
    protected $table ='tgz_messages';
    protected $fillable=[
        'sender_id',
        'recipient_id',
        'conversation_id',
        'read',
        'body',
        'type',
    ];
    public function conversation(){
        return $this->belongsTo(Conversation::class);
    }
    public function user(){
        return $this->belongsTo(User::class,'sender_id');
    }
}
