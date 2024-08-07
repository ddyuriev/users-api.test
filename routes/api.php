<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::resource('/user', UserController::class)->except([
    'create', 'edit',
])->missing(function () {
    return response()->json([
        'is_success' => false,
        'message' => 'User not found'
    ], 404);
});
