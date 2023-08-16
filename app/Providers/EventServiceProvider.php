<?php

namespace App\Providers;

use App\Events\AcceptFriendRequest;
use App\Events\FriendRequestSent;
use App\Events\ReactionPost;
use App\Listeners\SendFriendRequestNotification;
use App\Listeners\sendNotificationAcceptFriendRequest;
use App\Listeners\sendReactionPost;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        FriendRequestSent::class=>[
            SendFriendRequestNotification::class,
        ],
        AcceptFriendRequest::class=>[
            sendNotificationAcceptFriendRequest::class
        ],
        ReactionPost::class=>[
            sendReactionPost::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
