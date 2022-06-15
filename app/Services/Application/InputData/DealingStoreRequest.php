<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Infrastructures\Models\Eloquent\DomainDealing;

final class DealingStoreRequest
{
    private $domainDealing;

    /**
     * @param \App\Http\Requests\Frontend\Dealing\StoreRequest $storeRequest
     */
    public function __construct(
        \App\Http\Requests\Frontend\Dealing\StoreRequest $storeRequest
    ) {
        $this->domainDealing = new DomainDealing($storeRequest->validated());
    }

    /**
     * @return \App\Infrastructures\Models\Eloquent\DomainDealing
     */
    public function getInput(): \App\Infrastructures\Models\Eloquent\DomainDealing
    {
        return $this->domainDealing;
    }
}