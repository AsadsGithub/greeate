<?php

namespace Greeate\Greeate\Database\Factories;

use Greeate\Greeate\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition(): array
    {
        return [
            'uuid' => Str::uuid()->toString(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'password' => bcrypt('password'),
            'status' => 'active',
            'language' => 'en',
            'timezone' => 'UTC',
            'email_verified_at' => now(),
        ];
    }
}
