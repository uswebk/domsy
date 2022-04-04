<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use RuntimeException;

final class AlreadyVerifiedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Already verified', 1);
    }
}
