<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hp extends Model
{
    protected $connection = 'mysql3';
    protected $table = 'hps';
    protected $fillable =
    [
        'npk',
        'hp',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'npk', 'npk');
    }
}
