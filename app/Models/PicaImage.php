<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PicaImage extends Model
{
    protected $connection = 'mysql';
    protected $table = 'pica_images';
    protected $fillable = [
        'pica_id',
        'image',
    ];

    public function pica(): BelongsTo
    {
        return $this->belongsTo(Pica::class, 'pica_id', 'id');
    }
}
