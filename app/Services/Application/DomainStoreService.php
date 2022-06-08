<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Exceptions\Frontend\DomainExistsException;
use App\Exceptions\Frontend\NotOwnerException;

use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class DomainStoreService
{
    private $domainRepository;

    private $subdomainRepository;

    private $domainNotExistsService;

    private $registrarHasService;

    /**
     * @param \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
     * @param \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
     * @param \App\Services\Domain\Domain\NotExistsService $domainNotExistsService
     * @param \App\Services\Domain\Registrar\HasService $registrarHasService
     */
    public function __construct(
        \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository,
        \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository,
        \App\Services\Domain\Domain\NotExistsService $domainNotExistsService,
        \App\Services\Domain\Registrar\HasService $registrarHasService
    ) {
        $this->domainRepository = $domainRepository;
        $this->subdomainRepository = $subdomainRepository;
        $this->domainNotExistsService = $domainNotExistsService;
        $this->registrarHasService = $registrarHasService;
    }

    /**
     * @param \App\Services\Application\InputData\DomainStoreRequest $domainStoreRequest
     *
     * @throws DomainExistsException
     * @throws NotOwnerException
     *
     * @return void
     */
    public function handle(
        \App\Services\Application\InputData\DomainStoreRequest $domainStoreRequest
    ): void {
        $domainRequest = $domainStoreRequest->getInput();
        $userId = $domainRequest->user_id;

        try {
            if (! $this->domainNotExistsService->isNotExists($userId, $domainRequest->name)) {
                throw new DomainExistsException();
            }

            if (! $this->registrarHasService->isOwner($domainRequest->registrar_id, $userId)) {
                throw new NotOwnerException();
            }
        } catch (DomainExistsException | NotOwnerException $e) {
            Log::info($e->getMessage());

            throw $e;
        }

        DB::beginTransaction();
        try {
            $domain = $this->domainRepository->store([
                'name' => $domainRequest->name,
                'price' => $domainRequest->price,
                'user_id' => $userId,
                'registrar_id' => $domainRequest->registrar_id,
                'is_active' => $domainRequest->is_active,
                'is_transferred' => $domainRequest->is_transferred,
                'is_management_only' => $domainRequest->is_management_only,
                'purchased_at' => $domainRequest->purchased_at,
                'expired_at' => $domainRequest->expired_at,
                'canceled_at' => $domainRequest->canceled_at,
            ]);

            $this->subdomainRepository->store([
                'domain_id' => $domain->id,
                'subdomain' => '',
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }
}
