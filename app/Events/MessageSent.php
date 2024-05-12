<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Message;
use Illuminate\Foundation\Events\Dispatchable;

class MessageSent
{
    use Dispatchable;

    public function __construct(public readonly Message $message)
    {
    }
}
