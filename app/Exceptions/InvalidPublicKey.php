<?php

declare(strict_types=1);

namespace App\Exceptions;

class InvalidPublicKey extends ApiException implements SilencedException
{
    public function __construct()
    {
        parent::__construct('Invalid public key', 'INVALID_PUBLIC_KEY');
    }
}
