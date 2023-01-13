<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dealing;

use App\Exceptions\Api\ExistsFixedBillingException;
use App\Repositories\Domain\Dealing\DealingRepositoryInterface;

final class DeleteService
{
    private DealingRepositoryInterface $dealingRepository;

    /**
     * @param DealingRepositoryInterface $dealingRepository
     */
    public function __construct(DealingRepositoryInterface $dealingRepository)
    {
        $this->dealingRepository = $dealingRepository;
    }

    /**
     * @param \App\Models\DomainDealing $domainDealing
     * @return void
     * @throws ExistsFixedBillingException
     */
    public function handle(
        \App\Models\DomainDealing $domainDealing
    ): void {
        if ($domainDealing->hasFixedBilling()) {
            throw new ExistsFixedBillingException();
        }
        $this->dealingRepository->delete($domainDealing);
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return [];
    }
}
