<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idBarang = Barang::inRandomOrder()->value("id");
        return [
            "id_barang" => $idBarang,
            "status" => $this->faker->randomElement(["sudah_bayar", "belum_bayar"]),
            "pays" => $this->faker->randomElement(["pengirim", "penerima"]),
        ];
    }
}
