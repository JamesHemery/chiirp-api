<?php

declare(strict_types=1);

namespace App\Exceptions;

class CantSendMessageToYourself extends ApiException implements SilencedException
{
    public function __construct()
    {
        parent::__construct("You can't send a message to yourself", 'CANT_SEND_MESSAGE_TO_YOURSELF');
    }
}
