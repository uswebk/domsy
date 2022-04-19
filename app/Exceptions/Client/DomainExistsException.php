<?php

declare(strict_types=1);

namespace App\Exceptions\Client;

use Exception;

class DomainExistsException extends Exception
{
    public $message;

    public function __construct()
    {
        $this->message = 'Domain already exist';
    }
}
