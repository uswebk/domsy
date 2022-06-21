<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Exceptions\Frontend\DomainNotExistsException;
use App\Exceptions\Frontend\NotOwnerException;

use Exception;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class DealingStoreService
{
    private $dealingRepository;

    private $billingRepository;

    private $clientHasService;

    private $domainExistsService;

    private $userId;

    /**
     * @param \App\Infrastructures\Repositories\Domain\Dealing\DealingRepositoryInterface $dealingRepository
     * @param \App\Infrastructures\Repositories\Domain\Billing\BillingRepositoryInterface $billingRepository
     * @param \App\Services\Domain\Client\HasService $clientHasService
     * @param \App\Services\Domain\Domain\ExistsService $domainExistsService
     */
    public function __construct(
        \App\Infrastructures\Repositories\Domain\Dealing\DealingRepositoryInterface $dealingRepository,
        \App\Infrastructures\Repositories\Domain\Billing\BillingRepositoryInterface $billingRepository,
        \App\Services\Domain\Client\HasService $clientHasService,
        \App\Services\Domain\Domain\ExistsService $domainExistsService,
    ) {
        $this->dealingRepository = $dealingRepository;
        $this->billingRepository = $billingRepository;
        $this->clientHasService = $clientHasService;
        $this->domainExistsService = $domainExistsService;

        $this->userId = Auth::id();
    }

    /**
     * @param \App\Services\Application\InputData\DealingStoreRequest $domainDealingRequest
     *
     * @throws NotFoundException
     * @throws DomainNotExistsException
     *
     * @return void
    */
    public function handle(
        \App\Services\Application\InputData\DealingStoreRequest $domainDealingRequest
    ): void {
        $domainDealingInput = $domainDealingRequest->getInput();
        try {
            if (! $this->clientHasService->isOwner($domainDealingInput->client_id, $this->userId)) {
                throw new NotOwnerException();
            }

            if (! $this->domainExistsService->exists($domainDealingInput->domain_id, $this->userId)) {
                throw new DomainNotExistsException();
            }
        } catch (NotOwnerException | DomainNotExistsException $e) {
            Log::info($e->getMessage());

            throw $e;
        }

        DB::beginTransaction();
        try {
            $domainDealing = $this->dealingRepository->store([
                'user_id' => $this->userId,
                'domain_id' => $domainDealingInput->domain_id,
                'client_id' => $domainDealingInput->client_id,
                'subtotal' => $domainDealingInput->subtotal,
                'discount' => $domainDealingInput->discount,
                'billing_date' => $domainDealingInput->billing_date,
                'interval' => $domainDealingInput->interval,
                'interval_category' => $domainDealingInput->interval_category,
                'is_auto_update' => $domainDealingInput->is_auto_update,
                'is_halt' => $domainDealingInput->is_halt,
            ]);

            $this->billingRepository->store([
                'dealing_id' => $domainDealing->id,
                'total' => $domainDealing->getBillingAmount(),
                'billing_date' => $domainDealing->getNextBillingDate(),
                'is_fixed' => false,
                'changed_at' => null,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            report($e);

            throw $e;
        }
    }
}
