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
}
