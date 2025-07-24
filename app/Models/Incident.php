<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Incident extends Model
{
    protected $connection = 'mysql';
    protected $table = 'incidents';
    protected $fillable = [
        'accident_id',
        'category_id',
        'date',
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryAccident::class, 'category_id', 'id');
    }

    public function accident(): BelongsTo
    {
        return $this->belongsTo(Accident::class, 'accident_id', 'id');
    }
    public function pica(): BelongsTo
    {
        return $this->belongsTo(Pica::class, 'id', 'incident_id');
    }
}
