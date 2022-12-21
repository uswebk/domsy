<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Models\Domain;
use Illuminate\Support\Facades\Auth;

final class DomainStoreRequest
{
    private $domain;

    /**
     * @param \App\Http\Requests\Frontend\Domain\StoreRequest $storeRequest
     */
    public function __construct(
        \App\Http\Requests\Api\Domain\StoreRequest $storeRequest
    ) {
        $validated = array_merge($storeRequest->validated(), [
            'user_id' => Auth::id(),
        ]);

        $this->domain = new Domain($validated);
    }

    /**
     * @return \App\Models\Domain
     */
    public function getInput(): \App\Models\Domain
    {
        return $this->domain;
    }
}
