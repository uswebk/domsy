<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Http\Requests\Api\Domain\UpdateRequest;
use App\Models\Domain;
use Illuminate\Support\Facades\Auth;

final class DomainUpdateRequest
{
    private Domain $domain;

    /**
     * @param UpdateRequest $updateRequest
     */
    public function __construct(UpdateRequest $updateRequest)
    {
        $validated = array_merge($updateRequest->validated(), [
            'user_id' => Auth::id(),
        ]);

        $this->domain = new Domain($validated);
    }

    /**
     * @return Domain
     */
    public function getInput(): Domain
    {
        return $this->domain;
    }
}
