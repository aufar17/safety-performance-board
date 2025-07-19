<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $connection = 'mysql';
    protected $table = 'incidents';
    protected $fillable = [
        'accident',
        'category',
        'date',
    ];
}
