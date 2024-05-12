<?php

declare(strict_types=1);

namespace App\Exceptions;

class BadLoginCode extends ApiException implements SilencedException
{
    public function __construct()
    {
        parent::__construct('Bad login code.', 'BAD_LOGIN_CODE');
    }
}
