<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory,HasTimestamps;
    protected $table ='tgz_media';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'media_dir',
        'created_at',
        'updated_at'
    ];
    public function post(){
        return $this->belongsTo(Posts::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
