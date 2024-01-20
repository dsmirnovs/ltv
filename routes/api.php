<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TvProgrammesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => [
        'throttle:tv-api', // request limit per minute
        'tv_api_key' // check api key
    ]
], function () {
    Route::get('/upcoming/{channel_nr}', [TvProgrammesController::class, 'upcoming'])
        ->where('channel_nr', '[1-3]+'); //channels only from 1-3
    Route::get('/guide/{channel_nr}/{date}', [TvProgrammesController::class, 'guide'])
        ->where('channel_nr', '[1-3]+'); //channels only from 1-3
    Route::get('/on-air/{channel_nr}', [TvProgrammesController::class, 'onAir'])
        ->where('channel_nr', '[1-3]+'); //channels only from 1-3
});

Route::middleware(['throttle:tv-api', 'tv_api_key'])->post('/addProgram', [TvProgrammesController::class, 'addProgram']);
