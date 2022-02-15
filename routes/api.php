<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GitHubController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [UsersController::class, 'getUser']);
    Route::post('users', [UsersController::class, 'update']);
    Route::get('auth/logout', [AuthController::class, 'logout']);
});
Route::get('auth/invalidate', [AuthController::class, 'invalidate'])->name('invalidate');

Route::get('auth/github', [GitHubController::class, 'gitRedirect']);
Route::get('auth/github/callback', [GitHubController::class, 'gitCallback']);
Route::get('github/profile', [GitHubController::class, 'profile']);
Route::get('github/repos', [GitHubController::class, 'repositories']);
Route::get('github/repos/details', [GitHubController::class, 'repository']);
