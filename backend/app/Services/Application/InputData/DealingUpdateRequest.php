<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Infrastructures\Models\DomainDealing;

final class DealingUpdateRequest
{
    private $domainDealing;

    /**
     * @param \App\Http\Requests\Api\Dealing\UpdateRequest $updateRequest
     */
    public function __construct(
        \App\Http\Requests\Api\Dealing\UpdateRequest $updateRequest
    ) {
        $this->domainDealing = new DomainDealing($updateRequest->validated());
    }

    /**
     * @return \App\Infrastructures\Models\DomainDealing
     */
    public function getInput(): \App\Infrastructures\Models\DomainDealing
    {
        return $this->domainDealing;
    }
}
