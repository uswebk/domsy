<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Http\Requests\Api\Domain\StoreRequest;
use App\Models\Domain;
use Illuminate\Support\Facades\Auth;

final class DomainStoreRequest
{
    private Domain $domain;

    /**
     * @param StoreRequest $storeRequest
     */
    public function __construct(StoreRequest $storeRequest)
    {
        $validated = array_merge($storeRequest->validated(), [
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
