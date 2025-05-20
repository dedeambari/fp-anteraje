<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Payment;
use App\Models\PemrosessanBarang;
use App\Models\Staf;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed 10 barang lengkap beserta relasinya
        Barang::factory()
            ->count(10)
            ->create()
            ->each(function ($barang) {
                $kategori = $barang->kategori;
                $berat = $barang->berat ?? 0;
                $volume = $barang->volume ?? 0;

                // Hitung total tarif
                $total = 0;
                if ($kategori->hitung_berat) {
                    $total += $kategori->tarif_per_kg * $berat;
                }
                if ($kategori->hitung_volume) {
                    $total += $kategori->tarif_per_m3 * $volume;
                }
                if (!$kategori->hitung_berat && !$kategori->hitung_volume) {
                    $total += $kategori->tarif_flat;
                }
                $total += $kategori->biaya_tambahan;

                $barang->update([
                    'total_tarif' => $total,
                ]);

                // Buat Pemrosessan
                PemrosessanBarang::create([
                    'id_barang' => $barang->id,
                    'id_staf' => Staf::all()->random()->id,
                    'status_proses' => fake()->randomElement(['diproses', 'diantar', 'diterima']),
                    'catatan' => fake()->sentence(),
                    'bukti' => null,
                    'estimasi_waktu' => now()->addDays(rand(1, 10)),
                ]);

                // Buat Pembayaran
                Payment::create([
                    'id_barang' => $barang->id,
                    'pays' => fake()->randomElement(['pengirim', 'penerima']),
                    'status' => fake()->randomElement(['sudah_bayar', 'belum_bayar']),
                ]);
            });
    }
}
