<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikedPokemon extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'liked_pokemon_url',
    ];
}
