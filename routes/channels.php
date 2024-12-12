<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notifications.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('notifications.all', function ($user) {
    return $user->hasRole('general');
});
