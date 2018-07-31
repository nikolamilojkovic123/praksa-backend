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
 * Class NewGameEvent
 * @package App\Events
 */
class NewGameEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var $game object
     */
    public $game;

    /**
     * NewGameEvent constructor.
     * @param $game
     * @param $id
     */
    public function __construct($game, $id)
    {
        $this->game = $game;
        $this->id   = $id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('challenge.' . $this->id);
    }
}
