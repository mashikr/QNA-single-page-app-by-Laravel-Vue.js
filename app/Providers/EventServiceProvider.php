<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\LikeEvent;
use App\Listeners\LikeEventListener;
use App\Events\ReplyDeleteEvent;
use App\Listeners\ReplyDeleteEventListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        LikeEvent::class => [
            LikeEventListener::class,
        ],
        ReplyDeleteEvent::class => [
            ReplyDeleteEventListener::class,
        ],
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
