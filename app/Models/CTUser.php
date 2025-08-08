<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;


class CTUser extends Authenticatable
{
    protected $connection = 'mysql2';
    protected $table = 'ct_users_hash';
    protected $primaryKey = 'npk'; // penting!
    public $incrementing = false; // penting!
    protected $keyType = 'string'; // penting!
    protected $fillable = [
        'npk',
        'full_name',
        'pwd',
        'dept',
        'sect',
        'subsect',
        'golongan',
        'acting',
        'no_telp',
        'email',
    ];
    public $timestamps = false;

    public function otp(): HasMany
    {
        return $this->hasMany(OtpVerification::class, 'npk', 'npk');
    }

    public function getAuthPassword()
    {
        return $this->pwd;
    }
}
