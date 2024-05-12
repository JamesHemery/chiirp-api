<?php

declare(strict_types=1);

namespace App\Http\Controllers\Messages;

use App\Exceptions\AudioFileNotFound;
use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\ReadAudioMessageRequest;
use App\Models\Message;
use Symfony\Component\HttpFoundation\Response;

class ReadAudioMessageController extends Controller
{
    /**
     * @throws AudioFileNotFound
     */
    public function __invoke(ReadAudioMessageRequest $request, Message $message): Response
    {
        if (is_null($message->audio_file)) {
            throw new AudioFileNotFound($message);
        }

        dispatch(function () use ($message) {
            if (is_null($message->refresh()->listened_at)) {
                $message->listened_at = now();
                $message->save();
            }
        })->afterResponse();

        return $message->audio_file->toResponse($request);
    }
}
