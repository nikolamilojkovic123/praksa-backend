<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'joined',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function playerX()
    {
        return $this->hasMany('App\Models\Game', 'user_x_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function playerO()
    {
        return $this->hasMany('App\Models\Game', 'user_o_id');
    }

    /**
     * @return mixed
     */
    public function games()
    {
        return $this->playerX->merge($this->playerO);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function challenged()
    {
        return $this->belongsToMany(User::class, 'challenge_user', 'challenger_id',
            'challenged_id')->withPivot('status', 'id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function challengedBy()
    {
        return $this->belongsToMany(User::class, 'challenge_user', 'challenged_id',
            'challenger_id')->withPivot('status', 'id')->withTimestamps();
    }
}
