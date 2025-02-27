<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    protected $fillable = [
        "name",
        "user_hash_token"
    ];

    public function getTotalTimesAttribute(): float
    {
       return $this->trackRecords()->sum('time_ms') / 1000;
    }

    public function trackRecords(): HasMany
    {
       return $this->hasMany(TrackPlayerRecord::class);
    }
}
