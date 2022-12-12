<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AccountFactory extends Factory
{
    public function definition()
    {
        $company = $this->faker->company();

        return [
            'name' => Str::slug($company),
            'long_name' => $company,
            'database' => ['connection' => 'sqlite'],
        ];
    }
}
