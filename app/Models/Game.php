<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Game
 * @package App\Models
 */
class Game extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_x_id',
        'user_o_id',
        'active',
        'winner'
    ];

    /**
     * @var array
     */
    protected $winningArray = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9],
        [1, 4, 7],
        [2, 5, 8],
        [3, 6, 9],
        [1, 5, 9],
        [3, 5, 7],
    ];

    /**
     * @return bool
     */
    public static function checkWinner()
    {
        $game      = auth()->user()->games()->where('active', 1)->first();
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
