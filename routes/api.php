<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PokemonReactionController;
use App\Http\Resources\UserResource;

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
    return new UserResource($request->user());
});

Route::apiResource('pokemon', PokemonReactionController::class);
Route::post('pokemon/react', [PokemonReactionController::class, 'reaction'])->name('pokemon.react');
Route::get('pokemon/preferences/user', [PokemonReactionController::class, 'getUserPref'])->name('pokemon.preference');

