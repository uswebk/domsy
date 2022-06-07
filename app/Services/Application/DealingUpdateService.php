<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Exceptions\Frontend\DomainNotExistsException;
use App\Exceptions\Frontend\NotOwnerException;

use Exception;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

final class DealingUpdateService
{
    private $dealingRepository;

    private $clientHasService;

    private $domainExistsService;

    private $userId;

    /**
     * @param \App\Infrastructures\Repositories\Dealing\Domain\DealingRepositoryInterface $dealingRepository
     * @param \App\Services\Domain\Client\HasService $clientHasService
     * @param \App\Services\Domain\Domain\ExistsService $domainExistsService
     */
    public function __construct(
        \App\Infrastructures\Repositories\Dealing\Domain\DealingRepositoryInterface $dealingRepository,
        \App\Services\Domain\Client\HasService $clientHasService,
        \App\Services\Domain\Domain\ExistsService $domainExistsService
    ) {
        $this->dealingRepository = $dealingRepository;
        $this->clientHasService = $clientHasService;
        $this->domainExistsService = $domainExistsService;

        $this->userId = Auth::id();
    }

    /**
     * Undocumented function
     *
     * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealingRequest
     * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
     *
     * @throws NotOwnerException
     * @throws DomainNotExistsException
     *
     * @return void
     */
    public function handle(
        \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealingRequest,
        \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
    ): void {
        try {
            if (isset($domainDealingRequest->client_id) &&
            ! $this->clientHasService->isOwner($domainDealingRequest->client_id, $this->userId)) {
                throw new NotOwnerException();
            }

            if (isset($domainDealingRequest->domain_id) &&
            ! $this->domainExistsService->exists($domainDealingRequest->domain_id, $this->userId)) {
                throw new DomainNotExistsException();
            }

            $domainDealing->fill($domainDealingRequest->toArray());

            $this->dealingRepository->save($domainDealing);
        } catch (NotOwnerException | DomainNotExistsException $e) {
            Log::info($e->getMessage());

            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
