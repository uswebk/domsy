<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Infrastructures\Models\DomainDealing;

final class DealingStoreRequest
{
    private $domainDealing;

    /**
     * @param \App\Http\Requests\Api\Dealing\StoreRequest $storeRequest
     */
    public function __construct(
        \App\Http\Requests\Api\Dealing\StoreRequest $storeRequest
    ) {
        $this->domainDealing = new DomainDealing($storeRequest->validated());
    }

    /**
     * @return \App\Infrastructures\Models\DomainDealing
     */
    public function getInput(): \App\Infrastructures\Models\DomainDealing
    {
        return $this->domainDealing;
    }
}
