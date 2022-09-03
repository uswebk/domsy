<?php

declare(strict_types=1);

namespace App\Services\Application;

use Exception;

final class DealingUpdateService
{
    private $dealingRepository;

    /**
     * @param \App\Infrastructures\Repositories\Domain\Dealing\DealingRepositoryInterface $dealingRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Domain\Dealing\DealingRepositoryInterface $dealingRepository
    ) {
        $this->dealingRepository = $dealingRepository;
    }

    /**
     * @param \App\Services\Application\InputData\DealingUpdateRequest $dealingUpdateRequest
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     *
     * @return void
     */
    public function handle(
        \App\Services\Application\InputData\DealingUpdateRequest $dealingUpdateRequest,
        \App\Infrastructures\Models\DomainDealing $domainDealing
    ): void {
        $domainDealingRequest = $dealingUpdateRequest->getInput();

        try {
            $domainDealing->fill($domainDealingRequest->toArray());

            $this->dealingRepository->save($domainDealing);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
