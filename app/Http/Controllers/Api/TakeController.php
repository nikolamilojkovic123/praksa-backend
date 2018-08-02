<?php

namespace App\Http\Controllers\Api;

use App\Events\NewGameOverEvent;
use App\Events\NewTakeEvent;
use App\Http\Resources\TakeResource;
use App\Http\Controllers\Controller;

/**
 * Class TakeController
 * @package App\Http\Controllers\Api
 */
class TakeController extends Controller
{
    /**
     * @param $position
     * @return TakeResource|\Illuminate\Http\JsonResponse|string
     */
    public function create($position)
    {
        try {
            if ($this->takeService()->checkTurn()) {
                return response()->json(['message' => 'It\'s not your turn!'], 417);
            }
            $take = $this->takeService()->create($position);
            if (!$take) {
                return response()->json(['message' => 'Incorrect position!'], 417);
            }
            broadcast(new NewTakeEvent($take))->toOthers();
            $game = $this->gameService()->checkWinner($take->game_id);
            if ($game != false) {
                broadcast(new NewGameOverEvent($game));

                return new TakeResource($take);
            }

            return new TakeResource($take);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Failed to create resource.'], 417);
        }
    }
}
