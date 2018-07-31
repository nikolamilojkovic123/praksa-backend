<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\GameService;
use App\Services\UserService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @return UserService
     */
    public function userService()
    {
        return new UserService();
    }

    /**
     * @return AuthService
     */
    public function authService()
    {
        return new AuthService();
    }

    /**
     * @return GameService
     */
    public function gameService()
    {
        return new GameService();
    }
}
