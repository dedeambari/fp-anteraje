<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_barangs')->insert([
            [
                'id_kategori' => 1,
                'nama_kategori' => 'Kiloan',
                'hitung_berat' => true,
                'hitung_volume' => false,
                'tarif_per_kg' => 10000.00,
                'tarif_per_m3' => null,
                'tarif_flat' => null,
                'biaya_tambahan' => 0
            ],
            [
                'id_kategori' => 2,
                'nama_kategori' => 'Dokumen',
                'hitung_berat' => false,
                'hitung_volume' => false,
                'tarif_per_kg' => null,
                'tarif_per_m3' => null,
                'tarif_flat' => 5000.00,
                'biaya_tambahan' => 0
            ],
            // Tambahkan kategori lain sesuai kebutuhan...
        ]);
    }
}
