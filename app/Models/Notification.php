<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory,HasTimestamps;
    protected $table='tgz_notifications';
    protected $fillable = [
        'sender_id',
        'recipient_id',
        'data',
        'type',
        'is_read'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
