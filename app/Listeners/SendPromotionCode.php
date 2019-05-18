<?php

namespace App\Listeners;

use App\Events\NotifyUserRegisteredForOneMonth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPromotionCode
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
     * @param  NotifyUserRegisteredForOneMonth  $event
     * @return void
     */
    public function handle(NotifyUserRegisteredForOneMonth $event)
    {
        //
    }
}
