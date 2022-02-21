<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pokemon\UserController;

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

Route::post('favorite/set', [UserController::class, 'setFavorite'])->name('favorite.set');
Route::get('favorite/get', [UserController::class, 'getFavorite'])->name('favorite.get');

Route::post('likes/set', [UserController::class, 'addLikedPokemon'])->name('likes.set');
Route::get('likes/get', [UserController::class, 'getLikedPokemon'])->name('likes.get');

