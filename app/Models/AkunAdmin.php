<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class AkunAdmin extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    protected $guarded = ["id"];
}
