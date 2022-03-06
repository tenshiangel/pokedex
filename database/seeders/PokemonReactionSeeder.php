<?php

namespace Database\Seeders;

use App\Models\PokemonReaction;
use Illuminate\Database\Seeder;

class PokemonReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $data) {
            PokemonReaction::create($data);
        }
    }

    /**
     * List of user data.
     *
     * @return array
     */
    public function data()
    {
        return [
            [
                'user_id' => 1,
                'pokemon_id' => 24,
                'status' => 'like',
            ],
            [
                'user_id' => 1,
                'pokemon_id' => 18,
                'status' => 'favorite',
            ],
            [
                'user_id' => 2,
                'pokemon_id' => 95,
                'status' => 'hate',
            ],
            [
                'user_id' => 2,
                'pokemon_id' => 37,
                'status' => 'favorite',
            ],
            [
                'user_id' => 3,
                'pokemon_id' => 284,
                'status' => 'favorite',
            ],
            [
                'user_id' => 3,
                'pokemon_id' => 214,
                'status' => 'like',
            ],
            [
                'user_id' => 3,
                'pokemon_id' => 162,
                'status' => 'hate',
            ],
        ];
    }
}
