<?php

declare(strict_types=1);

namespace App\Infrastructures\Repositories\User;

interface UserLatestCodeRepositoryInterface
{
    public function next(): int;
}
