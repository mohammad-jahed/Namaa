<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/login', function (Request $request) {
//    return $request->user();
//});
Route::post('/login',[SubscriberController::class, 'login']);

Route::post('/subscribe',[SubscriberController::class, 'Subscribe']);

Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
Route::get('/subscribers',[SubscriberController::class, 'index']);
Route::get('/subscribers/{user}',[SubscriberController::class, 'show']);
Route::put('/subscribers/{user}',[SubscriberController::class, 'update']);
Route::delete('/subscribers/{user}',[SubscriberController::class, 'destroy']);
});

Route::group([
    'middleware' => ['auth:sanctum'],
], function () {

    Route::post('/blogs/create', [BlogController::class, 'store']);
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/{blog}', [BlogController::class, 'show']);
    Route::post('/blogs/{blog}', [BlogController::class, 'update']);
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy']);
});

