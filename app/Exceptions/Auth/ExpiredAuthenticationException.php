<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use RuntimeException;

final class ExpiredAuthenticationException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Authentication expired', 0);
    }
}
