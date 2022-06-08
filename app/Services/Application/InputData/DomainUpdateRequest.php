<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Infrastructures\Models\Eloquent\Domain;
use Illuminate\Support\Facades\Auth;

final class DomainUpdateRequest
{
    private $domain;

    /**
     * @param \App\Http\Requests\Frontend\Domain\UpdateRequest $updateRequest
     */
    public function __construct(
        \App\Http\Requests\Frontend\Domain\UpdateRequest $updateRequest
    ) {
        $validated = array_merge($updateRequest->validated(), [
            'user_id' => Auth::id(),
        ]);

        $this->domain = new Domain($validated);
    }

    /**
     * @return \App\Infrastructures\Models\Eloquent\Domain
     */
    public function getInput(): \App\Infrastructures\Models\Eloquent\Domain
    {
        return $this->domain;
    }
}
