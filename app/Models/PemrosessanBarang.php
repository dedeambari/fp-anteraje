<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemrosessanBarang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    public function staf()
    {
        return $this->belongsTo(Staf::class, 'id_staf', 'id');
    }
}
