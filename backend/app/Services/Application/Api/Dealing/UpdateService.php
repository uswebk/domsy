<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dealing;

use App\Http\Resources\DomainDealingResource;
use App\Models\DomainDealing;
use App\Repositories\Domain\Dealing\DealingRepositoryInterface;
use App\Services\Application\InputData\DealingUpdateRequest;

final class UpdateService
{
    private DealingRepositoryInterface $dealingRepository;

    private DomainDealing $dealing;

    /**
     * @param DealingRepositoryInterface $dealingRepository
     */
    public function __construct(DealingRepositoryInterface $dealingRepository)
    {
        $this->dealingRepository = $dealingRepository;
    }

    /**
     * @param DealingUpdateRequest $dealingUpdateRequest
     * @param DomainDealing $domainDealing
     * @return void
     */
    public function handle(DealingUpdateRequest $dealingUpdateRequest, DomainDealing $domainDealing): void
    {
        $domainDealingRequest = $dealingUpdateRequest->getInput();

        $domainDealing->fill($domainDealingRequest->toArray());

        $this->dealing = $this->dealingRepository->save($domainDealing);
    }

    /**
     * @return DomainDealingResource
     */
    public function getResponse(): DomainDealingResource
    {
        return new DomainDealingResource($this->dealing);
    }
}
