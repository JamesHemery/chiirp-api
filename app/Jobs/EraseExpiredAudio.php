<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EraseExpiredAudio implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        Message::query()
            ->whereNotNull('listened_at')
            ->where('listened_at', '<', now()->subMinutes(Message::EXPIRES_AFTER_MINUTES))
            ->whereNull('erased_at')
            ->each(function (Message $message) {
                if ($message->audio_file) {
                    $message->audio_file->delete();
                    $message->erased_at = now();
                    $message->save();
                }
            });
    }
}
