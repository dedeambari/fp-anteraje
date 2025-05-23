<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    use HasFactory;

    protected $guarded = ["id_kategori"];

    protected $primaryKey = "id_kategori";

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id_kategori');
    }

    public function hitungTarif($volume, $berat)
    {
        if (!is_null($this->tarif_flat)) {
            return $this->tarif_flat + ($this->biaya_tambahan ?? 0);
        }

        if ($this->hitung_volume) {
            return ($this->tarif_per_m3 ?? 0) * $volume + ($this->biaya_tambahan ?? 0);
        }

        if ($this->hitung_berat) {
            return ($this->tarif_per_kg ?? 0) * $berat + ($this->biaya_tambahan ?? 0);
        }

        return 0;
    }




}
