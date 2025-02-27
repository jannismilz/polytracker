<?php

namespace App\Filament\Resources\TrackResource\Pages;

use App\Filament\Resources\TrackResource;
use App\Jobs\RefreshTrack;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrack extends EditRecord
{
    protected static string $resource = TrackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterEdit(): void
    {
        $track = $this->record;

        info("Refreshing $track");

        if($track) {
            RefreshTrack::dispatch($track);
        }
    }
}
