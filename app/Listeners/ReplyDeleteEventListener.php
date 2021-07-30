<?php

namespace App\Listeners;

use App\Events\ReplyDeleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReplyDeleteEventListener
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
     * @param  ReplyDeleteEvent  $event
     * @return void
     */
    public function handle(ReplyDeleteEvent $event)
    {
        //
    }
}
