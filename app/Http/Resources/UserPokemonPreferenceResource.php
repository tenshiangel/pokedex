<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PokemonReactionResource;

class UserPokemonPreferenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'favorite' => new PokemonReactionResource($this->favorite),
            'likes' => $this->likedPokemons->each(function ($pokemon) {
                new PokemonReactionResource($pokemon);
            }),
            'hates' => $this->hatedPokemons->each(function ($pokemon) {
                new PokemonReactionResource($pokemon);
            }),
        ];
    }
}
