<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Exceptions\Client\DomainNotExistsException;
use App\Exceptions\Client\NotOwnerException;

use Exception;

use Illuminate\Support\Facades\Log;

final class DealingStoreService
{
    private $dealingRepository;

    private $clientHasService;

    private $domainExistsService;

    private $userId;

    /**
     * @param \App\Infrastructures\Repositories\Dealing\DomainDealingRepositoryInterface $dealingRepository
     * @param \App\Services\Domain\Client\HasService $clientHasService
     * @param \App\Services\Domain\Domain\ExistsService $domainExistsService
     */
    public function __construct(
        \App\Infrastructures\Repositories\Dealing\DomainDealingRepositoryInterface $dealingRepository,
        \App\Services\Domain\Client\HasService $clientHasService,
        \App\Services\Domain\Domain\ExistsService $domainExistsService
    ) {
        $this->dealingRepository = $dealingRepository;
        $this->clientHasService = $clientHasService;
        $this->domainExistsService = $domainExistsService;

        $this->userId = Auth::id();
    }

    /**
      * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
      *
      * @throws NotFoundException
      * @throws DomainNotExistsException
      *
      * @return void
      */
    public function handle(
        \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
    ): void {
        try {
            if (! $this->clientHasService->isOwner($domainDealing->client_id, $this->userId)) {
                throw new NotOwnerException();
            }

            if (! $this->domainExistsService->exists($domainDealing->domain_id, $this->userId)) {
                throw new DomainNotExistsException();
            }

            $this->dealingRepository->store([
                'user_id' => $this->userId,
                'domain_id' => $domainDealing->domain_id,
                'client_id' => $domainDealing->client_id,
                'subtotal' => $domainDealing->subtotal,
                'discount' => $domainDealing->discount,
                'billing_date' => $domainDealing->billing_date,
                'interval' => $domainDealing->interval,
                'interval_category' => $domainDealing->interval_category,
                'is_auto_update' => $domainDealing->is_auto_update,
            ]);
        } catch (NotOwnerException | DomainNotExistsException $e) {
            Log::info($e->getMessage());

            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
