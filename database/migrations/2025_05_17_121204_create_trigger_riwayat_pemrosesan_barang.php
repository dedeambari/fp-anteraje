<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Trigger INSERT
        DB::unprepared('
            CREATE TRIGGER trg_insert_history_prosess_barang AFTER INSERT ON tbl_pemrosessan_barangs
            FOR EACH ROW
            BEGIN
                INSERT INTO tbl_history_prosess_barangs
                (id_barang, id_staf, status_proses, catatan, bukti, created_at, updated_at)
                VALUES
                (NEW.id_barang, NEW.id_staf, NEW.status_proses, NEW.catatan, NEW.bukti, NOW(), NEW.updated_at);
            END
        ');

        // Trigger UPDATE
        DB::unprepared('
            CREATE TRIGGER trg_update_history_prosess_barang AFTER UPDATE ON tbl_pemrosessan_barangs
            FOR EACH ROW
            BEGIN
                IF NEW.status_proses != OLD.status_proses THEN
                    INSERT INTO tbl_history_prosess_barangs
                    (id_barang, id_staf, status_proses, catatan, bukti, created_at, updated_at)
                    VALUES
                    (NEW.id_barang, NEW.id_staf, NEW.status_proses, NEW.catatan, NEW.bukti, NOW(), NEW.updated_at);
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_insert_riwayat_pemrosesan');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_update_riwayat_pemrosesan');
    }
};
