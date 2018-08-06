<?php

namespace App\Http\Controllers\Api;

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
            $challenge_id = auth()->user()->challenged()
                ->withPivot('id')
                ->orderBy('challenge_user.created_at', 'desc')
                ->first()->pivot->id;

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
        $challenger_id = $this->userService()->acceptChallenge($id);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function headToHead($id)
    {
        $games = $this->gameService()->headToHead($id);
        if ($games) {
//            return GameResource::collection($games);
            return response()->json(['data' => $games], 200);
        }

        return response()->json(['message' => 'No games to show.'], 417);
    }

    public function myGames()
    {
        try {
            $games = $this->gameService()->myGames();

            return GameResource::collection($games);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Failed to retrieve resource.'], 404);
        }
    }
}
