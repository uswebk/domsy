<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\Client;

interface EloquentClientQueryServiceInterface
{
    /**
     * @param integer $id
     * @return \App\Infrastructures\Models\Eloquent\Client
     */
    public function findById(int $id): \App\Infrastructures\Models\Eloquent\Client;
}
