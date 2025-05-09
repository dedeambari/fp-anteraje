<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kategori_barangs', function (Blueprint $table) {
            $table->id("id_kategori");
            $table->string('nama_kategori');
            $table->boolean('hitung_berat');
            $table->boolean('hitung_volume');
            $table->decimal('tarif_per_kg', 10, 2)->nullable();
            $table->decimal('tarif_per_m3', 10, 2)->nullable();
            $table->decimal('tarif_flat', 10, 2)->nullable();
            $table->decimal('biaya_tambahan', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_barangs');
    }
};
