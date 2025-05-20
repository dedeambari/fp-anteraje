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
        Schema::create('pemrosessan_barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')
                ->references('id')->on('barangs')->onDelete('cascade');
            $table->unsignedBigInteger('id_staf');
            $table->foreign('id_staf')
                ->references('id')->on('stafs')->onDelete('cascade');
            $table->enum('status_proses', ['diproses', 'diantar', 'diterima'])->default('diproses');
            $table->text('catatan')->nullable();
            $table->string('bukti')->nullable();
            $table->dateTime('estimasi_waktu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemrosessan_barangs');
    }
};
