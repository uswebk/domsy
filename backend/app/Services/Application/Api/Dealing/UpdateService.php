<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dealing;

use App\Http\Resources\DomainDealingResource;
use Exception;

final class UpdateService
{
    private $dealingRepository;

    private $dealing;

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

            $this->dealing = $this->dealingRepository->save($domainDealing);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return \App\Http\Resources\DomainDealingResource
     */
    public function getResponse(): \App\Http\Resources\DomainDealingResource
    {
        return new DomainDealingResource($this->dealing);
    }
}
