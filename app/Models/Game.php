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
    protected $with = [
        'userX',
        'userO'
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
     * @return array
     */
    public function getWinningArray()
    {
        return $this->winningArray;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userX()
    {
        return $this->belongsTo('App\Models\User', 'user_x_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userO()
    {
        return $this->belongsTo('App\Models\User', 'user_o_id');
    }
}
