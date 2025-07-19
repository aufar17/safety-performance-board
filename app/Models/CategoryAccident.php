<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAccident extends Model
{
    protected $connection = 'mysql';
    protected $table = 'category_accidents';
    protected $fillable = [
        'category',
    ];
}
