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

Route::post('proctoring/change_photo', [\App\Http\Controllers\ProctoringController::class, 'changePhoto']);

Route::group(['middleware' => "proctoring", 'prefix' => "proctoring"], function () {
    Route::get('photos', [\App\Http\Controllers\ProctoringController::class, 'allPhotos']);

    Route::get('accept_photo/{identification_photo}', [\App\Http\Controllers\IdentificationPhotoController::class, 'accept']);
    Route::get('reject_photo/{identification_photo}', [\App\Http\Controllers\IdentificationPhotoController::class, 'reject']);

    Route::post('cheatings/delete', [\App\Http\Controllers\CheatingsController::class, 'delete']);
});

Route::get('test', function () {
    return response()->json([
        'a' => [1,2], 'b' => [3,4]
    ]);
});