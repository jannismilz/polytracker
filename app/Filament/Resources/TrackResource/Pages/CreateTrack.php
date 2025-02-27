<?php

namespace App\Filament\Resources\TrackResource\Pages;

use App\Filament\Resources\TrackResource;
use App\Jobs\RefreshTrack;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTrack extends CreateRecord
{
    protected static string $resource = TrackResource::class;

    protected function afterCreate(): void
    {
        $track = $this->record;

        info("Refreshing $track");

        if($track) {
            RefreshTrack::dispatch($track);
        }
    }
}
