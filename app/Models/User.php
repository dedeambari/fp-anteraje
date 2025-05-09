<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*    protected $fillable = [
           'name',
           'email',
           'password',
       ]; */
    protected $table = 'tbl_m_user_ld';
    protected $primaryKey = 'id_tmuld';

    // Nonaktifkan timestamp otomatis
    public $timestamps = false;
    protected $fillable = [
        'name',
        'username',
        'email',
        'no_hp',
        'password',
        'id_tmru_ld',
        'status_deactive',
        'created_by_tmuld',
        'img_tmuld',
    ];

    protected $dates = ['deleted_at'];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            // Set default value untuk kolom id_tmru_ld
            if (is_null($user->id_tmru_ld)) {
                $user->id_tmru_ld = 2;
            }

            // Set default value untuk kolom status_deactive
            if (is_null($user->status_deactive_tmuld)) {
                $user->status_deactive_tmuld = 1;
            }

            // Set default value untuk kolom created_by
            if (is_null($user->created_by_tmuld)) {
                $user->created_by_tmuld = 1;
            }

            // Set default value untuk kolom img
            if (is_null($user->img_tmuld)) {
                $user->img_tmuld = 'default.jpeg';
            }
        });
    }


    public function role()
    {
        return $this->belongsTo(tbl_m_role::class, 'id_tmru_ld', 'id_tmru_ld');
    }


    public function pesanan()
    {
        return $this->hasMany(tbl_pesanan::class, 'id_tmuld', 'id_tmuld');
    }


}
