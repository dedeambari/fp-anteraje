<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KategoriBarang>
 */
class KategoriBarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nama_kategori" => $this->faker->word(),
            "hitung_berat" => $this->faker->boolean(),
            "hitung_volume" => $this->faker->boolean(),
            "tarif_per_kg" => $this->faker->randomFloat(2, 1000, 1000000),
            "tarif_per_m3" => $this->faker->randomFloat(2, 1000, 1000000),
            "tarif_flat" => $this->faker->randomFloat(2, 1000, 1000000),
            "biaya_tambahan" => $this->faker->randomFloat(2, 1000, 1000000),
        ];
    }
}
