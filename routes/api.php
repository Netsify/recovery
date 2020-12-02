<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('jwt', [\App\Http\Controllers\JWTController::class, 'makeToken']);

Route::get('jwt/decode/token/{token}', [\App\Http\Controllers\JWTController::class, 'decode']);

Route::get('testing_jwt', [\App\Http\Controllers\JWTController::class, 'testing']);

Route::post('proctoring/result', [\App\Http\Controllers\ProctoringController::class, 'getResult'])
    ->middleware('proctoring');

Route::get('test', function () {
    $info = \App\Models\Proctoring\InfoType::first();
    $type = \App\Models\Proctoring\CheatingType::first();
    $cheating = new \App\Models\Proctoring\Cheating();
    $cheating->info_type_id = $info->id;
    $cheating->cheating_type_id = $type->id;
    $cheating->proctoring_result_id = 1;
    $cheating->save();
});