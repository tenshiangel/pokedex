<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\PokemonReactionRequest;
use App\Http\Resources\PokemonReactionResource;
use App\Http\Resources\UserPokemonPreferenceResource;
use App\Models\PokemonReaction;
use Illuminate\Http\Request;

class PokemonReactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PokemonReactionRequest $request
     * @return App\Models\Response
     */
    public function store($request)
    {
        $pokemonReaction = PokemonReaction::create($request->all());

        return new PokemonReactionResource($pokemonReaction);
    }

    /**
     * Get the specific pokemon reaction.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Models\PokemonReaction
     */
    public function show(Request $request)
    {
        return PokemonReaction::where(['status' => $request->status, 'pokemon_id' => $request->pokemon_id, 'user_id' => $request->user()->id])->first();
    }

    /**
     * Update the specific user reaction data.
     *
     * @param  \App\Http\Requests\PokemonReactionRequest $request
     * @param  \App\Models\PokemonReaction $pokemonReaction
     * @return \Illuminate\Http\Response
     */
    public function update(PokemonReactionRequest $request, PokemonReaction $pokemonReaction)
    {
        if ($this->scan($request, $pokemonReaction))
            return $this->destroy($pokemonReaction);

        $pokemonReaction->update($request->all());

        return new PokemonReactionResource($pokemonReaction);
    }

    /**
     * Remove the specific user reaction data.
     *
     * @param  \App\Models\PokemonReaction $pokemonReaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(PokemonReaction $pokemonReaction)
    {
        $pokemonReaction->delete();

        return response()->noContent();
    }

    /**
     * Submit the user's reaction (like/hate/fave)
     *
     * @param  \App\Http\Requests\PokemonReactionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function reaction(PokemonReactionRequest $request)
    {
        $request['user_id'] = $request->user()->id;

        if ($request->status == 'like') {
            $likes = $request->user()->likedPokemons;

            /* 
             *  If the pokemon like data already exists:
             *  e.g. This pokemon is already liked by user, means this pokemon will be unliked
            */
            if ($this->show($request))
                return $this->destroy($this->show($request));   // returned as removing the like status
            /* 
             *  If there are list of liked pokemons:
             *  Replacing the oldest data with the recent one: $this->store()
            */
            else if ($likes && count($likes) >= 3)
                $this->destroy($likes[0]);

        }
        else if ($request->status == 'hate') {
            $hates = $request->user()->hatedPokemons;

            /* 
             *  If the pokemon hate data already exists:
             *  e.g. This pokemon is already liked by user, means this pokemon will be unliked
            */
            if ($this->show($request))
                return $this->destroy($this->show($request));   // returned as removing the hate status
            /* 
             *  If there are list of hated pokemons:
             *  Replacing the oldest data with the recent one: $this->store()
            */
            else if ($hates && count($hates) >= 3)
                $this->destroy($hates[0]);

        }
        else {
            $favorite = $request->user()->favorite;

            /* 
            *  If the pokemon favorite data already exists:
            *  This will be updated, or removed. Please refer in `function scan()`
            */
            if ($favorite)
                return $this->update($request, $favorite);

        }

        return $this->store($request);
    }
    
    /**
     * Get the user's pokemon preferneces (fave/like/hate).
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getUserPref(Request $request) {
        return new UserPokemonPreferenceResource($request->user());
    }

    /**
     * Get the preferences from all users.
     *
     */
    public function prefList()
    {
        $users = User::all();
        $users->each(function ($user) {
            $user = [
                'preferences' => [
                    'favorite' => new PokemonReactionResource($user->favorite),
                    'likes' => $user->likedPokemons->each(function ($pokemon) {
                        new PokemonReactionResource($pokemon);
                    }),
                    'hates' => $user->hatedPokemons->each(function ($pokemon) {
                        new PokemonReactionResource($pokemon);
                    }),
                ],
            ];
        });
        return $users;
    }

    /**
     *  Check if the favorite pokemon data already exists
     *  If the `pokemon_id` matches: means removed. Otherwise, it will be updated.
     *
     * @param  \App\Http\Requests\PokemonReactionRequest $request
     * @param  \App\Models\PokemonReaction $pokemonReaction
     * @return bool
     */
    protected function scan(PokemonReactionRequest $request, PokemonReaction $pokemonReaction): bool {
        $condition = false;

        if (
            $pokemonReaction->user_id == $request->user()->id
            && $pokemonReaction->pokemon_id == $request->pokemon_id
            && $pokemonReaction->status == $request->status
        )
            $condition = true;
        
        return $condition;
    }
}
