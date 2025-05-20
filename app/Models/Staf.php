<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staf extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $guarded = ['id'];

    public function pemrosessan()
    {
        return $this->hasMany(PemrosessanBarang::class, 'id_staf', 'id');
    }

    // updateQtyTask
    public function updateQtyTask($qty)
    {
        $this->qty_task += $qty;
        return $this->save();
    }

}
