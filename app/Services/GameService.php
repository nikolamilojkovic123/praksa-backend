<?php

namespace App\Services;

use App\Models\Game;

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
}
