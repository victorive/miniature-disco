<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\PostController;
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

Route::prefix('auth')->group(function () {

    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);

    Route::middleware('auth')->group(function () {
        Route::post('logout', LogoutController::class);
    });
});

Route::prefix('posts')->middleware('auth')->group(function () {
    Route::get('/', [PostController::class, 'getPosts'])->middleware('can:view_posts');
    Route::get('/{post_id}', [PostController::class, 'getPostById'])->middleware('can:read_posts');

    Route::post('/', [PostController::class, 'createPost'])->middleware('can:create_posts');
    Route::put('/{post_id}', [PostController::class, 'updatePost'])
        ->middleware('can:update_posts');
    Route::delete('/{post_id}', [PostController::class, 'deletePost'])
        ->middleware('can:delete_posts');
});
