<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Take;

/**
 * Class GameService
 * @package App\Services
 */
class GameService
{
    /**
     * @param $id
     * @return mixed
     */
    public function create($id)
    {
        $game = Game::create([
            'user_x_id' => auth()->user()->id,
            'user_o_id' => $id,
            'active'    => 1,
            'winner'    => '?',
        ]);

        return $game;
    }

    /**
     * @param int $game_id
     * @return bool
     */
    public function checkWinner($game_id)
    {
        $game      = Game::find($game_id);
        $takeArray = [];
        $takes     = Take::where('game_id', $game->id)->where('user_id', auth()->user()->id)->get();
        foreach ($takes as $take) {
            $takeArray[] = $take->position;
        }
        foreach ($game->winningArray as $row) {
            if (count(array_intersect($takeArray, $row)) == 3) {
                $game->winner = auth()->user()->name;
                $game->active = 0;
                $game->save();

                return $game;
            }
        }
        if (count(Take::where('game_id', $game->id)->get()) == 9) {
            $game->winner = 'Draw';
            $game->active = 0;
            $game->save();

            return $game;
        }

        return false;
    }
}
