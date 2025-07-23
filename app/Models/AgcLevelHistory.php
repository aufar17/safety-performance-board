<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgcLevelHistory extends Model
{
    protected $connection = 'mysql';
    protected $table = 'agc_level_histories';
    protected $fillable = [
        'agc_level_id',
        'date',
        'fr',
        'sr'
    ];

    public function agc(): BelongsTo
    {
        return $this->belongsTo(AgcLevel::class, 'agc_level_id', 'id');
    }
}
