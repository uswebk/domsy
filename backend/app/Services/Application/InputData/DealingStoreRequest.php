<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Http\Requests\Api\Dealing\StoreRequest;
use App\Models\DomainDealing;

final class DealingStoreRequest
{
    private DomainDealing $domainDealing;

    /**
     * @param StoreRequest $storeRequest
     */
    public function __construct(StoreRequest $storeRequest)
    {
        $this->domainDealing = new DomainDealing($storeRequest->validated());
    }

    /**
     * @return DomainDealing
     */
    public function getInput(): DomainDealing
    {
        return $this->domainDealing;
    }
}
