<?php

declare(strict_types=1);

namespace App\Infrastructures\Queries\DNS;

use App\Infrastructures\Models\Eloquent\Domain;

final class EloquentDomainQueryService
{
    private $model;

    public function __construct(Domain $domain)
    {
        $this->model = $domain;
    }

    public function getFirstOrFailByIdUserID($id, $userId): Domain
    {
        return $this->model
        ->where('id', $id)
        ->where('user_id', $userId)->firstOrFail();
    }
}