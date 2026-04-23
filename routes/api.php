<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticationController;


Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working'
    ]);
});

Route::post('register', [AuthenticationController::class, 'register']);