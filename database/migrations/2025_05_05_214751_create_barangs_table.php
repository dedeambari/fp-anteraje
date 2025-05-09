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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->text('deskripsi_barang')->nullable();
            $table->decimal('berat', 8, 2)->nullable();
            $table->decimal('volume', 8, 3)->nullable();
            $table->dateTime('estimasi_waktu')->nullable();
            $table->string('nomor_resi');
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->foreign('id_kategori')
                ->references('id_kategori')->on('kategori_barangs')->onDelete('set null');
            $table->unsignedBigInteger('id_pengirim')->nullable();
            $table->foreign('id_pengirim')
                ->references('id')->on('pengirim_barangs')->onDelete('set null');
            $table->unsignedBigInteger('id_penerima')->nullable();
            $table->foreign('id_penerima')
                ->references('id')->on('penerima_barangs')->onDelete('set null');
            $table->decimal('total_tarif', 10, 2)->nullable(); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_barangs');
    }
};
