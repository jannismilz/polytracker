<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    protected $fillable = [
        "identifier",
        "name",
        "code"
    ];

    public function trackRecords(): HasMany
    {
        return $this->hasMany(TrackPlayerRecord::class);
    }
}
