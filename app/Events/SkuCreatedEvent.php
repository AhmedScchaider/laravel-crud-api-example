<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SkuCreatedEvent extends Event
{
    use SerializesModels;

    public $sku;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($sku)
    {
        $this->sku = $sku;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
