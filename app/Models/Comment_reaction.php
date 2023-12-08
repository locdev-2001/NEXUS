<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment_reaction extends Model
{
    use HasFactory, HasTimestamps;
    protected $table = 'tgz_comment_reaction';
    protected $fillable = [
        'comment_id',
        'post_id',
        'user_id',
        'created_at',
        'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function comment(){
        return $this->belongsTo(Post_comments::class,'comment_id');
    }
    public function post(){
        return $this->belongsTo(Posts::class,'post_id');
    }
}
