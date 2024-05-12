<?php

declare(strict_types=1);

namespace App\Exceptions;

class CantAddYourselfAsBuddy extends ApiException implements SilencedException
{
    public function __construct()
    {
        parent::__construct("You can't add yourself as buddy", 'CANT_ADD_YOURSELF_AS_BUDDY');
    }
}
