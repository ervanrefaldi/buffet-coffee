<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug-session', function () {
    return [
        'session_all' => session()->all(),
        'user_id' => session('user_id'),
        'user_role' => session('user_role'),
    ];
});
