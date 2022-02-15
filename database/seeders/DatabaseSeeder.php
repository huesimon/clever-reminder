<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Simon Rasmussen',
            'email' => 'simon.d.rasmussen@gmail.com',
            'password' => bcrypt('password'),
            'telegram_user_id' => '151336314',
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
