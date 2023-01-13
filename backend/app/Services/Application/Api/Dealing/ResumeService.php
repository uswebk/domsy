<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dealing;

use App\Http\Resources\DomainDealingResource;
use App\Models\DomainDealing;
use App\Repositories\Domain\Dealing\DealingRepositoryInterface;
use Exception;

final class ResumeService
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
     * @param DomainDealing $domainDealing
     * @return void
     * @throws Exception
     */
    public function handle(DomainDealing $domainDealing): void
    {
        $domainDealing->is_halt = false;
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
