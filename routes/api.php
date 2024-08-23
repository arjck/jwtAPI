<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::controller(AuthController::class)
    ->group(function () {
        Route::post('logout', 'logout');
        Route::post('login', 'login');
        Route::post('register', 'register');
    }
);
