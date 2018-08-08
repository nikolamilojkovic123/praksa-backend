<?php

namespace App\Http\Controllers\Api;

use App\Events\NewChallengeDeclinedEvent;
use App\Events\NewChallengeEvent;
use App\Events\NewGameEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\UserResource;
use App\Models\User;

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
            $challenge_id = $this->userService()->getChallengeId();

            broadcast(new NewChallengeEvent(auth()->user(), $id, $challenge_id));

            return response()->json(['challenge_id' => $challenge_id], 200);
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
        $challenger_id = $this->userService()->approveChallenge($id);
        if (!$challenger_id) {
            return response()->json(['message' => 'Invalid challenge id.'], 404);
        }
        try {
            $game = $this->gameService()->create($challenger_id);
            broadcast(new NewGameEvent($game, $id));

            return new GameResource($game);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Failed to create resource.'], 417);
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function declineChallenge($id)
    {
        broadcast(new NewChallengeDeclinedEvent($id));

        return $this->userService()->rejectChallenge($id);
    }

    /**
     * @param null $id
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function userInfo($id = null)
    {
        try {
            if (isset($id)) {
                $user = User::find($id);
            } else {
                $user = auth()->user();
            }

            return new UserResource($user);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Failed to retrieve resource.'], 404);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function headToHead($id)
    {
        try {
            $games = $this->gameService()->headToHead($id);

            return GameResource::collection($games);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Failed to retrieve resource.'], 404);
        }
    }


    /**
     * @param null $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function pastGames($id = null)
    {
        try {
            $games = $this->gameService()->pastGames($id);

            return GameResource::collection($games);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Failed to retrieve resource.'], 404);
        }
    }
}
