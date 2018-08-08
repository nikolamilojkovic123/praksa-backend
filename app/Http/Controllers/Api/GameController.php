<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Http\Controllers\Controller;

/**
 * Class GameController
 * @package App\Http\Controllers\Api
 */
class GameController extends Controller
{
    /**
     * @param int $id
     * @return GameResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $game = Game::with('userX', 'userO')->find($id);
        if ($game) {
            return new GameResource($game);
        }
        return response()->json(['message' => 'Failed to retrieve resource.'], 404);
    }
}
