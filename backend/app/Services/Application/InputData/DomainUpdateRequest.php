<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Infrastructures\Models\Domain;
use Illuminate\Support\Facades\Auth;

final class DomainUpdateRequest
{
    private $domain;

    /**
     * @param \App\Http\Requests\Api\Domain\UpdateRequest $updateRequest
     */
    public function __construct(
        \App\Http\Requests\Api\Domain\UpdateRequest $updateRequest
    ) {
        $validated = array_merge($updateRequest->validated(), [
            'user_id' => Auth::id(),
        ]);

        $this->domain = new Domain($validated);
    }

    /**
     * @return \App\Infrastructures\Models\Domain
     */
    public function getInput(): \App\Infrastructures\Models\Domain
    {
        return $this->domain;
    }
}
