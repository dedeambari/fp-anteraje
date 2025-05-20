<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategori', 'id_kategori');
    }

    public function pemrosessan()
    {
        return $this->hasOne(PemrosessanBarang::class, 'id_barang', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id_barang', 'id');
    }

    public function pengirim()
    {
        return $this->belongsTo(PengirimBarang::class, 'id_pengirim', 'id');
    }

    public function penerima()
    {
        return $this->belongsTo(PenerimaBarang::class, 'id_penerima', 'id');
    }

    public function historyProgressBarang()
    {
        return $this->hasMany(HistoryProsessBarang::class, 'id_barang', 'id');
    }

}
