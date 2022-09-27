<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dealing;

use App\Exceptions\Api\ExistsFixedBillingException;
use Exception;

final class DeleteService
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
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @return void
     *
     * @throws ExistsFixedBillingException
     */
    public function handle(
        \App\Infrastructures\Models\DomainDealing $domainDealing
    ): void {
        try {
            if ($domainDealing->hasFixedBilling()) {
                throw new ExistsFixedBillingException();
            }
            $this->dealingRepository->delete($domainDealing);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return [];
    }
}
