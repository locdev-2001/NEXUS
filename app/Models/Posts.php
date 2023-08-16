<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory, HasTimestamps;
    protected $table = 'tgz_posts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'content_text',
        'post_mode',
        'created_at',
        'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Post_comments::class,'post_id')->orderBy('created_at','desc');
    }
    public function reactions(){
        return $this->hasMany(Post_reactions::class,'post_id');
    }
    public function media(){
        return $this->hasMany(Media::class, 'post_id');
    }
}
