<?php

namespace App\Listeners;

use App\Events\AcceptFriendRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class sendNotificationAcceptFriendRequest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AcceptFriendRequest  $event
     * @return void
     */
    public function handle(AcceptFriendRequest $event)
    {
        //
    }
}
