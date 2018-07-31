<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /**
     *
     */
    public function joinTournament()
    {
        //TODO
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function challenge($id)
    {
        try {
            auth()->user()->challenged()->attach($id);
            $challenge_id = auth()->user()->challenged()
                ->withPivot('id')
                ->orderBy('challenge_user.created_at', 'desc')
                ->first()->pivot->id;

            //fire new challenge event -- broadcast(new NewChallengeEvent(auth()->user(), $id, $challenge_id)); TODO

            return $challenge_id;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create resource.'], 417);
        }
    }

    /**
     * @param $id
     * @return GameResource|\Illuminate\Http\JsonResponse
     */
    public function acceptChallenge($id)
    {
        $challenger_id = $this->userService()->acceptChallenge($id);
        if (!$challenger_id) {
            return response()->json(['message' => 'Invalid challenge id.'], 404);
        }
        try {
            $game = $this->gameService()->create($challenger_id);
            //fire new game event -- broadcast(new NewGameEvent($game, $id)); TODO

            return new GameResource($game);

        } catch (\Exception $exception) {
            return response()->json(['message' => 'Failed to create resource.'], 417);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function declineChallenge($id)
    {
        return auth()->user()->challengedBy()
            ->newPivotStatement()
            ->where('challenge_user.id', $id)
            ->update(['status' => false]);
    }
}
