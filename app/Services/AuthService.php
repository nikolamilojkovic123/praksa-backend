<?php

namespace App\Services;


use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{
    /**
     * @param $request
     * @return array
     */
    public function getToken($request)
    {
        $credentials = $request->only('email', 'password');
        $token       = JWTAuth::attempt($credentials);
        JWTAuth::setToken($token);
        $token = [
            'token_type'   => 'Bearer',
            'access_token' => $token
        ];
        return $token;
    }
}
