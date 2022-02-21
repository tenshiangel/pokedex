<?php

namespace App\Http\Controllers\pokemon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favorite;
use App\Models\LikedPokemon;
use App\Models\HatedPokemon;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\LikedPokemonResource;
use App\Http\Resources\HatedPokemonResource;

class UserController extends Controller
{
    public function addLikedPokemon(Request $request) {
        $data = LikedPokemon::where('user_id', $request->user_id)->take(3)->get();
        if (count($data) >= 3) {
            $this->removeLikedPokemon($request);
        }
        else {
            $liked = LikedPokemon::create($request->all());
        }

        return User::find($request->user_id)->likedPokemons;
    }

    public function removeLikedPokemon(Request $request) {
        if ($request->type == 'new') {
            $liked_pokemon = LikedPokemon::where('user_id', $request->user_id)->first();
            $liked_pokemon->delete();
        }
        else {
            $liked_pokemon = LikedPokemon::where('user_id', $request->user_id)->where('liked_pokemon_url', $request->liked_pokemon_url)->first();
            $liked_pokemon->delete();
        }

        return response()->noContent();
    }

    public function getLikedPokemon(Request $request) {
        
    }

    public function addHatedPokemon(Request $request) {
        
    }

    public function removeHatedPokemon(Request $request) {
        
    }

    public function getHatedPokemon(Request $request) {
        
    }

    public function setFavorite(Request $request) {
        if (Favorite::where('user_id', $request->user_id)->first()) {
            $favorite = Favorite::where('user_id', $request->user_id)->first();

            /*  If the same favorite button (contains same URL) toggled twice, pokemon will be remove as favorite */
            if ($favorite->favorite_pokemon_url == $request->favorite_pokemon_url) {
                return $this->removeFavorite($request);
            }
            else {
                $favorite->favorite_pokemon_url = $request->favorite_pokemon_url;
                $favorite->save();
            }
        }
        else {
            $favorite = Favorite::create($request->all());
        }

        return new FavoriteResource($favorite);
    }

    public function getFavorite(Request $request) {
        $favorite = Favorite::where('user_id', $request->user_id)->first();

        if (! $favorite)
            return response()->noContent();

        return new FavoriteResource($favorite);
    }

    private function removeFavorite(Request $request) {
        Favorite::where('user_id', $request->user_id)->delete();

        return response()->noContent();
    }
}
