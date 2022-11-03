<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use \App\Http\Controllers\PostController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
});
Route::prefix('users')->group(function () {
    // should return all users with posts and
    // all comments which the current user left under any post
    Route::controller(UserController::class)->group(function () {
        Route::get('/', 'index');
    });
});

Route::apiResources([
    'posts' => PostController::class,
    'comments' => CommentController::class,
]);
