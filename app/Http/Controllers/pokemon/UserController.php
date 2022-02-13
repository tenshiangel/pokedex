<?php

namespace App\Http\Controllers\pokemon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\LikedPokemon;
use App\Models\HatedPokemon;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\LikedPokemonResource;
use App\Http\Resources\HatedPokemonResource;

class UserController extends Controller
{
    public function addLikedPokemon() {
        
    }

    public function removeLikedPokemon() {

    }

    public function getLikedPokemon() {
        
    }

    public function addHatedPokemon() {
        
    }

    public function removeHatedPokemon() {
        
    }

    public function getHatedPokemon() {
        
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
