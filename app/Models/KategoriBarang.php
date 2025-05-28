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
        $total = 0;

        if ($this->hitung_volume && !is_null($this->tarif_per_m3)) {
            $total += $this->tarif_per_m3 * $volume;
        }

        if ($this->hitung_berat && !is_null($this->tarif_per_kg)) {
            $total += $this->tarif_per_kg * $berat;
        }

        if (!is_null($this->tarif_flat)) {
            $total += $this->tarif_flat;
        }

        if (!is_null($this->biaya_tambahan)) {
            $total += $this->biaya_tambahan;
        }

        return $total;
    }

}
