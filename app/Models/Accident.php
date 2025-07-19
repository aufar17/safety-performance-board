<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accident extends Model
{
    protected $connection = 'mysql';
    protected $table = 'accidents';
    protected $fillable = [
        'accident',
    ];
}
