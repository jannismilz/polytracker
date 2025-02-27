<?php

namespace App\Jobs;

use App\Models\Player;
use App\Models\Track;
use App\Models\TrackPlayerRecord;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use function Laravel\Prompts\error;

class RefreshTrack implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Track $track
    ) {}

    public function handle(): void
    {
        info("Started processing $this->track");

        // If track was refreshed less than 2 minutes ago, return
        if ($this->track->refreshed_at > now()->subMinutes(2)) {
            info("Track already refreshed in last 2 minutes!");
            return;
        }

        $players = Player::all();
        $trackId = $this->track->identifier;

        info("Processing track $trackId for {$players->count()} players.");

        foreach ($players as $player) {
            try {
                $url = "https://vps.kodub.com:43273/leaderboard?version=0.4.2&trackId={$trackId}&skip=0&amount=1&userTokenHash={$player->user_hash_token}";
                info($url);
                $leaderboard = Http::get($url);

                $userEntry = $leaderboard["userEntry"];

                if(empty($userEntry)) {
                    info("Failed to get user entry from $url");
                    return;
                }

                TrackPlayerRecord::upsert([
                    "track_id" => $this->track->id,
                    "player_id" => $player->id,
                    "time_ms" => $userEntry["frames"],
                ], uniqueBy: ['track_id', 'player_id'], update: ["time_ms"]);
            } catch (\Exception $e) {
                error($e->getMessage());
            }
        }

        info("Finished processing $trackId for {$players->count()} players.");

        $this->track->refreshed_at = now();
        $this->track->save();
    }
}
