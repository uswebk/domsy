<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Http\Requests\Api\Dealing\UpdateRequest;
use App\Models\DomainDealing;

final class DealingUpdateRequest
{
    private DomainDealing $domainDealing;

    /**
     * @param UpdateRequest $updateRequest
     */
    public function __construct(UpdateRequest $updateRequest)
    {
        $this->domainDealing = new DomainDealing($updateRequest->validated());
    }

    /**
     * @return DomainDealing
     */
    public function getInput(): DomainDealing
    {
        return $this->domainDealing;
    }
}
