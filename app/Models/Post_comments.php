<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
class Post_comments extends Model
{
    use HasFactory, HasTimestamps;
    protected $table = 'tgz_post_comments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'content',
        'comment_media_dir',
        'parent_id',
        'lft',
        'rgt',
        'created_at',
        'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function replies()
    {
        return $this->hasMany(Post_comments::class, 'parent_id');
    }
    public function commentReaction(){
        return $this->hasMany(Comment_reaction::class,'comment_id');
    }
}
