<?php

namespace App\Events;

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
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int $game_id
     */
    protected $game_id;

    /**
     * @var $take
     */
    public $take;

    /**
     * NewTakeEvent constructor.
     * @param $game_id
     * @param $take
     */
    public function __construct($take, $game_id)
    {
        $this->game_id = $game_id;
        $this->take    = $take;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('game.' . $this->game_id);
    }
}
