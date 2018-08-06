<?php

namespace App\Events;

use App\Models\Take;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class NewTakeEvent
 * @package App\Events
 */
class NewTakeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    /**
     * @var $take
     */
    public $take;

    /**
     * NewTakeEvent constructor.
     * @param $take
     */
    public function __construct(Take $take)
    {
        $this->take = $take;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('game.' . $this->take->game_id);
    }
}
