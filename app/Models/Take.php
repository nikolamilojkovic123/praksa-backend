<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Take
 * @package App\Models
 */
class Take extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'user_id',
        'position',
        'symbol'
    ];

    /**
     * @return bool
     */
    public static function checkTurn()
    {
        $game = auth()->user()->games()->where('active', 1)->first();
        if (Take::where('game_id', $game->id)->get()->count() == 0) {
            if ($game->user_o_id == auth()->user()->id) {
                return true;
            } else {
                return false;
            }
        }
        if (Take::where('game_id', $game->id)->get()->count() % 2 == 0) {
            if ($game->user_o_id == auth()->user()->id) {
                return true;
            } else {
                return false;
            }
        } else {
            if ($game->user_x_id == auth()->user()->id) {
                return true;
            } else {
                return false;
            }
        }
    }
}
