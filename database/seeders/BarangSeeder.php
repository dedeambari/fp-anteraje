<?php

namespace Database\Seeders;

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
        DB::table('barangs')->insert([
            'pengirim_barang' => 'Andi Wijaya',
            'penerima_barang' => 'Budi Santoso',
            'nama_barang' => 'Laptop',
            'kateogri_barang' => 'Dokumen',
            'staf_pengirim' => 'Agus Santoso',
            'nomor_resi' => 'EXP123456789',
        ]);
    }
}
