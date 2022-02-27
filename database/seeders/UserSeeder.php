<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $data) {
            User::create($data);
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
                'first_name' => 'Lyralei',
                'last_name' => 'Jenkins',
                'email' => 'lyrajenkins@example.com',
                'password' => Hash::make('password'),
                'birthdate' => '1996-05-12',
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'birthdate' => '1995-08-29',
            ],
            [
                'first_name' => 'Pokemon',
                'last_name' => 'Trainer',
                'email' => 'trainer@example.com',
                'password' => Hash::make('password'),
                'birthdate' => '1997-12-19',
            ],
        ];
    }
}
