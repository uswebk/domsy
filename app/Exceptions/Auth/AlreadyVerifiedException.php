<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use RuntimeException;

final class AlreadyVerifiedException extends RuntimeException
{
    public $message;

    public function __construct()
    {
        $this->message = 'Already verified';
    }
}
