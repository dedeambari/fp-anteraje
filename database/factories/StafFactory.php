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
            'no_hp' => '08' . $this->faker->numberBetween(1000000000, 9999999999),
            'password' => Hash::make('Staf_313212'),
            'qty_task' => $this->faker->randomNumber(1),
            'profile' => null,
            'transportasi' => $this->faker->randomElement(['motor', 'mobil']),
            'created_at' => now(),
        ];
    }
}
