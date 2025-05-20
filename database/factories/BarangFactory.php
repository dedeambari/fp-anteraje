<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nama_barang" => $this->faker->words(2, true),
            "deskripsi_barang" => $this->faker->sentence(5),
            "berat" => $this->faker->randomFloat(2, 0, 100),
            "volume" => $this->faker->randomFloat(2, 0, 100),
            "nomor_resi" => generateNoResi(),
            "id_kategori" => \App\Models\KategoriBarang::factory(),
            "id_pengirim" => \App\Models\PengirimBarang::factory(),
            "id_penerima" => \App\Models\PenerimaBarang::factory(),
            "total_tarif" => null
        ];
    }
}
