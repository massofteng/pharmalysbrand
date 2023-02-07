<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'name'              => 'pharmalysuser',
            'email'             => 'pharmalys@gmail.com',
            'password'          => bcrypt('pharmalys@admin'),
            'remember_token'    => Str::random(10),
        ];

        $user = User::updateOrCreate(['email' => $user['email']], $user);
    }
}
