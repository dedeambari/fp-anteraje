<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staf>
 */
class StafFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'no_hp' => $this->faker->phoneNumber(),
            'password' => Hash::make('password'), // default password
            'qty_task' => $this->faker->randomNumber(2),
            'profile' => null,
            'transportasi' => $this->faker->randomElement(['motor', 'mobil']),
            'created_at' => now(),
        ];
    }
}
