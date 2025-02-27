<?php

use Illuminate\Support\Facades\Schedule;
use App\Models\Track;
use App\Jobs\RefreshTrack;

Schedule::call(function () {
    foreach (Track::all() as $track) {
        RefreshTrack::dispatch($track);
    }
})->everyTwoMinutes();