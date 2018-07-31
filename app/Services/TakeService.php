<?php

namespace App\Services;

use App\Models\Take;

/**
 * Class TakeService
 * @package App\Services
 */
class TakeService
{
    /**
     * @param $position
     * @return bool
     */
    public function create($position)
    {
        $game = auth()->user()->games()->where('active', 1)->first();
        if ($game->user_x_id == auth()->user()->id) {
            $symbol = 'x';
        }
        if ($game->user_o_id == auth()->user()->id) {
            $symbol = 'o';
        }
        if (in_array($position, Take::where('game_id', $game->id)->pluck('position')->toArray())) {
            return false;
        }
        $take = Take::create([
            'game_id'  => $game->id,
            'user_id'  => auth()->user()->id,
            'position' => $position,
            'symbol'   => $symbol
        ]);

        return $take;
    }
}
