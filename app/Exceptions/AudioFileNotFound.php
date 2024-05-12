<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Models\Message;

class AudioFileNotFound extends ApiException implements SilencedException
{
    public function __construct(public readonly Message $model)
    {
        parent::__construct(sprintf('Audio file not found for message %s.', $this->model->public_id), 'AUDIO_FILE_NOT_FOUND');
    }
}
