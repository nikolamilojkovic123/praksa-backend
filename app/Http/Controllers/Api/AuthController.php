<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->userService()->create($request);

            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create resource.'], 417);
        }
    }

    /**
     * @param LoginRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $token = $this->authService()->getToken($request);

            return (new UserResource(JWTAuth::authenticate()))->additional($token);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid credentials.'], 401);
        }
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['success' => 'Logged out successfully'], 200);
    }
}
