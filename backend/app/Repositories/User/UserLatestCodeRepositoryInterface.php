<?php

declare(strict_types=1);

namespace App\Repositories\User;

interface UserLatestCodeRepositoryInterface
{
    /**
     * @return integer
     */
    public function next(): int;
}
