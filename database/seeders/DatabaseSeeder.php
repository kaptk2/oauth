<?php

namespace Database\Seeders;

use App\Models\Account;
use Database\Seeders\landlord\AccountSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Account::checkCurrent()
           ? $this->runTenantSpecificSeeders()
           : $this->runLandlordSpecificSeeders();
    }

    public function runTenantSpecificSeeders()
    {
        $this->call(UserSeeder::class);
    }

    public function runLandlordSpecificSeeders()
    {
        $this->call(AccountSeeder::class);
    }
}
