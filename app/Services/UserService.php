<?php

namespace App\Services;


use App\Models\User;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{

    /**
     * @param $request
     * @return mixed
     */
    public function create($request)
    {
        $user = User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'joined'   => 0,
        ]);

        return $user;
    }

    /**
     * @param $id
     * @return bool
     */
    public function approveChallenge($id)
    {
        if (auth()->user()->challengedBy()
            ->newPivotStatement()
            ->where('challenge_user.id', $id)
            ->where('status', null)
            ->update(['status' => true])) {

            return auth()->user()->challengedBy()
                ->where('challenge_user.id', $id)
                ->where('status', true)
                ->first()->id;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function setIncludeGames()
    {
        $_GET['include'] = 'games';

        return true;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function rejectChallenge($id)
    {
        return auth()->user()->challengedBy()
            ->newPivotStatement()
            ->where('challenge_user.id', $id)
            ->update(['status' => false]);
    }

    /**
     * @return mixed
     */
    public function getChallengeId()
    {
        return auth()->user()->challenged()
            ->withPivot('id')
            ->orderBy('challenge_user.created_at', 'desc')
            ->first()->pivot->id;
    }
}
