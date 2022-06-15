<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Infrastructures\Models\Eloquent\DomainDealing;

final class DealingUpdateRequest
{
    private $domainDealing;

    /**
     * @param \App\Http\Requests\Frontend\Dealing\UpdateRequest $updateRequest
     */
    public function __construct(
        \App\Http\Requests\Frontend\Dealing\UpdateRequest $updateRequest
    ) {
        $this->domainDealing = new DomainDealing($updateRequest->validated());
    }

    /**
     * @return \App\Infrastructures\Models\Eloquent\DomainDealing
     */
    public function getInput(): \App\Infrastructures\Models\Eloquent\DomainDealing
    {
        return $this->domainDealing;
    }
}