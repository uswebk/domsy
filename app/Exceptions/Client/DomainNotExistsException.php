<?php

declare(strict_types=1);

namespace App\Exceptions\Client;

use Exception;

final class DomainNotExistsException extends Exception
{
    public $message;

    public function __construct()
    {
        $this->message = 'Domain does not exist';
    }
}
