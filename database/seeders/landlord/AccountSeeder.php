<?php

namespace Database\Seeders\landlord;

use App\Models\Account;
use App\Models\Domain;
use App\Models\OAuthProvider;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        Account::factory()->create([
            'name' => 'test1',
            'long_name' => 'Test 1',
            'database' => [
                'driver' => 'sqlite',
                'database' => database_path('test1.sqlite'),
            ]
        ]);

        Domain::factory()->create([
            'account_id' => 1,
            'name' => 'test1',
        ]);

        OAuthProvider::factory()->create([
            'account_id' => 1,
            'name' => 'google',
        ]);
    }
}
