<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'User Test',
            'email' => 'user@example.com',
            'password' => bcrypt('test1234'),
        ]);

        User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'password' => bcrypt('test1234'),
        ]);
    }
}
