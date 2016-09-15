<?php

namespace App\Listeners;

use App\Events\SkuCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class SkuCreatedListener implements ShouldQueue
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
     * @param  SkuCreatedEvent  $event
     * @return void
     */
    public function handle(SkuCreatedEvent $event)
    {
        Log::info('Sku Created: ' . $event->sku);
    }
}
