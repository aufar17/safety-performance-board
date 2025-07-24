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
        'incident_id',
    ];

    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class, 'incident_id', 'id');
    }
    public function image(): HasMany
    {
        return $this->hasMany(PicaImage::class, 'pica_id', 'id');
    }
}
