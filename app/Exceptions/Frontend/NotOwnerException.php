<?php

declare(strict_types=1);

namespace App\Exceptions\Frontend;

use Exception;

final class NotOwnerException extends Exception
{
    public $message;

    public function __construct()
    {
        $this->message = 'Illegal operation';
    }
}
