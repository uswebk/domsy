<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use Exception;

final class ExpiredAuthenticationException extends Exception
{
    public function __construct()
    {
        parent::__construct('Authentication expired', 0);
    }
}
