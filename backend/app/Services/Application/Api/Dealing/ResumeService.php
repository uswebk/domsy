<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dealing;

use App\Http\Resources\DomainDealingResource;
use Exception;

final class ResumeService
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
     *
     * @return void
     */
    public function handle(
        \App\Infrastructures\Models\DomainDealing $domainDealing
    ): void {
        try {
            $domainDealing->is_halt = false;
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
