<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasTimestamps;
    protected $table = 'tgz_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//    ];
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function posts()
    {
        return $this->hasMany(Posts::class);
    }
    public function friends()
    {
        return $this->belongsToMany(User::class, 'tgz_friends', 'user_id', 'friend_id');
    }
    public function media(){
        return $this->hasMany(Media::class);
    }
    /**
     * Get the notification routing information for the database driver.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array
     */
    public function routeNotificationForDatabase($notification)
    {
        return array(['id' => $this->id]);
    }
}
