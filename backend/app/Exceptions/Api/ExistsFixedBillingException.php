<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

use RuntimeException;

final class ExistsFixedBillingException extends RuntimeException
{
    public $message;

    public function __construct()
    {
        $this->message = 'exists fixed billing';
    }
}
