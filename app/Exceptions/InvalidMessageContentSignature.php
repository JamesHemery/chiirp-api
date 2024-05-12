<?php

declare(strict_types=1);

namespace App\Exceptions;

class InvalidMessageContentSignature extends ApiException implements SilencedException
{
    public function __construct()
    {
        parent::__construct('Signature is invalid.', 'INVALID_MESSAGE_CONTENT_SIGNATURE');
    }
}
