<?php

namespace Database\Factories;

use App\Models\Staf;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PemrosessanBarang>
 */
class PemrosesanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stafId = Staf::inRandomOrder()->value("id");
        return [
            "id_barang" => $this->faker->numberBetween(1, 10),
            "id_staf" => $stafId,
            "status_proses" => $this->faker->randomElement(["diproses", "diantar", "diterima"]),
            "catatan" => $this->faker->sentence(5),
            "bukti" => null,
            "estimasi_waktu" => $this->faker->dateTimeBetween('+1 day', '+1 month'),
        ];
    }
}
