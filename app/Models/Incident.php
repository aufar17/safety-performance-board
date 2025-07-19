<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Incident extends Model
{
    protected $connection = 'mysql';
    protected $table = 'incidents';
    protected $fillable = [
        'accident',
        'category',
        'date',
    ];


    public function category(): HasMany
    {
        return $this->hasMany(CategoryAccident::class, 'category');
    }

    public function accident(): HasMany
    {
        return $this->hasMany(Accident::class, 'accident');
    }
}
