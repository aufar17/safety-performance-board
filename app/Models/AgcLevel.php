<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgcLevel extends Model
{
    protected $connection = 'mysql';
    protected $table = 'agc_levels';

    protected $fillable = [
        'category',
        'color',
        'fr_min',
        'fr_max',
        'sr_min',
        'sr_max',
    ];

    public function agcHistory(): HasMany
    {
        return $this->hasMany(AgcLevelHistory::class, 'id', 'agc_level_id');
    }

    public function scopeMatchFr($query, $fr)
    {
        return $query
            ->where(function ($q) use ($fr) {
                $q->whereNull('fr_min')->orWhere('fr_min', '<=', $fr);
            })
            ->where(function ($q) use ($fr) {
                $q->whereNull('fr_max')->orWhere('fr_max', '>=', $fr);
            });
    }

    public function scopeMatchSr($query, $sr)
    {
        return $query
            ->where(function ($q) use ($sr) {
                $q->whereNull('sr_min')->orWhere('sr_min', '<=', $sr);
            })
            ->where(function ($q) use ($sr) {
                $q->whereNull('sr_max')->orWhere('sr_max', '>=', $sr);
            });
    }
}
