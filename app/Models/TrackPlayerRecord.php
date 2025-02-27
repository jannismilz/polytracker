<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackPlayerRecord extends Model
{
    protected $fillable = [
        'track_id',
        'player_id',
        'time_ms'
    ];
}
