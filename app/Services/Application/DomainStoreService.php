<?php

declare(strict_types=1);

namespace App\Services\Application;

use Exception;

use Illuminate\Support\Facades\DB;

final class DomainStoreService
{
    private $domainRepository;

    private $subdomainRepository;

    /**
     * @param \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
     * @param \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository,
        \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository,
    ) {
        $this->domainRepository = $domainRepository;
        $this->subdomainRepository = $subdomainRepository;
    }

    /**
     * @param \App\Services\Application\InputData\DomainStoreRequest $domainStoreRequest
     *
     * @return void
     */
    public function handle(
        \App\Services\Application\InputData\DomainStoreRequest $domainStoreRequest
    ): void {
        $domainRequest = $domainStoreRequest->getInput();

        DB::beginTransaction();
        try {
            $domain = $this->domainRepository->store([
                'name' => $domainRequest->name,
                'price' => $domainRequest->price,
                'user_id' => $domainRequest->user_id,
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
