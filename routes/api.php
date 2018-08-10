<?php

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => ['jwt.auth']], function () {

    Route::get('logout', 'Api\AuthController@logout');

    Route::get('users/{id?}', 'Api\UserController@userInfo');
    Route::get('head-to-head/{id}', 'Api\UserController@headToHead');
    Route::get('past-games/{id?}', 'Api\UserController@pastGames');

    Route::get('challenges/{id}', 'Api\UserController@challenge');
    Route::get('challenges/accept/{id}', 'Api\UserController@acceptChallenge');
    Route::get('challenges/decline/{id}', 'Api\UserController@declineChallenge');

    Route::get('takes/{position}', 'Api\TakeController@create');

    Route::get('games/{id}', 'Api\GameController@show');

});
