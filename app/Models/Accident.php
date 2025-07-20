<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accident extends Model
{
    protected $connection = 'mysql';
    protected $table = 'accidents';
    protected $fillable = [
        'accident',
    ];


    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class, 'accident_id', 'id');
    }
}
