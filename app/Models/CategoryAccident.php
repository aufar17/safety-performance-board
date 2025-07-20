<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryAccident extends Model
{
    protected $connection = 'mysql';
    protected $table = 'category_accidents';
    protected $fillable = [
        'category',
    ];

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class, 'id', 'category_id');
    }
}
