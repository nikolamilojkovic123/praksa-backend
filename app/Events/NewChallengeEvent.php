<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class NewChallengeEvent
 * @package App\Events
 */
class NewChallengeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var $challenger object
     */

    public $challenger;
    /**
     * @var int $challenge_id
     */

    public $challenge_id;

    /**
     * NewChallengeEvent constructor.
     * @param User $challenger
     * @param $id
     * @param $challenge_id
     */
    public function __construct(User $challenger, $id, $challenge_id)
    {
        $this->challenger   = $challenger;
        $this->id           = $id;
        $this->challenge_id = $challenge_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->id);
    }
}
