<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

// Đăng ký route cho broadcasting với middleware 'auth'
// Broadcast::routes(['middleware' => ['auth']]);

Broadcast::channel('notifications.{id}', function ($user, $id) {
    // Log::info('User ID: ' . $user->id . ' - Channel ID: ' . $id);
    // Log::info('Comparison Result: ' . ((int) $user->id === (int) $id ? 'true' : 'false'));
    return (int) $user->id === (int) $id;
});
