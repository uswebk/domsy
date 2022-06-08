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
     * @param \App\Services\Application\InputData\DealingUpdateRequest $dealingUpdateRequest
     * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
     *
     * @throws NotOwnerException
     * @throws DomainNotExistsException
     *
     * @return void
     */
    public function handle(
        \App\Services\Application\InputData\DealingUpdateRequest $dealingUpdateRequest,
        \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
    ): void {
        $domainDealingRequest = $dealingUpdateRequest->getInput();

        $clientId = $domainDealingRequest->client_id;
        $domainId = $domainDealingRequest->domain_id;

        try {
            if (isset($clientId) &&
            ! $this->clientHasService->isOwner($clientId, $this->userId)) {
                throw new NotOwnerException();
            }

            if (isset($domainId) &&
            ! $this->domainExistsService->exists($domainId, $this->userId)) {
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
