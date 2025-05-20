<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PengirimBarang>
 */
class PengirimBarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nama" => $this->faker->name(),
            "no_hp" => '08' . $this->faker->numberBetween(1000000000, 9999999999),
            "alamat" => $this->faker->address(),
        ];
    }
}
