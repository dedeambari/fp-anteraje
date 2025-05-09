<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staf extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function pemrosessan()
    {
        return $this->hasMany(PemrosessanBarang::class, 'id_staf', 'id');
    }
}
