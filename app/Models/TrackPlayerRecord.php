<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackPlayerRecord extends Model
{
    protected $fillable = [
        'track_id',
        'player_id',
        'time_ms'
    ];

    public function getTimeFormattedAttribute(): float
    {
       return $this->time_ms / 1000;
    }
    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
