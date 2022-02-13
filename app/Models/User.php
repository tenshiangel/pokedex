<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birthdate',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get user's favorite Pokemon.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function favorite()
    {
        return $this->hasOne(Favorite::class);
    }

    /**
     * Get user's favorite Pokemon.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likedPokemons()
    {
        return $this->hasMany(LikedPokemon::class);
    }

    /**
     * Get user's favorite Pokemon.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hatedPokemons()
    {
        return $this->hasMany(HatedPokemon::class);
    }
}
