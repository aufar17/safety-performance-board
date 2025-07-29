<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pica extends Model
{
    protected $connection = 'mysql';
    protected $table = 'picas';
    protected $fillable = [
        'date_start',
        'date_end',
    ];


    public function image(): HasMany
    {
        return $this->hasMany(PicaImage::class, 'pica_id', 'id');
    }
}
