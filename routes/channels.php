<?php

Broadcast::channel('lobby', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

Broadcast::channel('challenge.{id}', function ($user) {
    return true;
});

Broadcast::channel('game.{id}', function ($user) {
    return true;
});
