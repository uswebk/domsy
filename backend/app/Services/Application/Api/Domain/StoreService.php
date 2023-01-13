<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Http\Resources\DomainResource;
use App\Models\Domain;
use App\Repositories\Domain\DomainRepositoryInterface;
use App\Repositories\Subdomain\SubdomainRepositoryInterface;
use App\Services\Application\InputData\DomainStoreRequest;
use Exception;
use Illuminate\Support\Facades\DB;

final class StoreService
{
    private DomainRepositoryInterface $domainRepository;

    private SubdomainRepositoryInterface $subdomainRepository;

    private Domain $domain;

    /**
     * @param DomainRepositoryInterface $domainRepository
     * @param SubdomainRepositoryInterface $subdomainRepository
     */
    public function __construct(
        DomainRepositoryInterface $domainRepository,
        SubdomainRepositoryInterface $subdomainRepository,
    ) {
        $this->domainRepository = $domainRepository;
        $this->subdomainRepository = $subdomainRepository;
    }

    /**
     * @param DomainStoreRequest $domainStoreRequest
     * @return void
     * @throws Exception
     */
    public function handle(DomainStoreRequest $domainStoreRequest): void
    {
        $domainRequest = $domainStoreRequest->getInput();

        DB::beginTransaction();
        try {
            $this->domain = $this->domainRepository->store([
                'name' => $domainRequest->name,
                'price' => $domainRequest->price,
                'user_id' => $domainRequest->user_id,
                'registrar_id' => $domainRequest->registrar_id,
                'is_active' => $domainRequest->is_active,
                'is_transferred' => $domainRequest->is_transferred,
                'is_management_only' => $domainRequest->is_management_only,
                'is_fetching_dns' => $domainRequest->is_fetching_dns,
                'purchased_at' => $domainRequest->purchased_at,
                'expired_at' => $domainRequest->expired_at,
                'canceled_at' => $domainRequest->canceled_at,
            ]);

            $this->subdomainRepository->store([
                'domain_id' => $this->domain->id,
                'subdomain' => '',
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    /**
     * @return DomainResource
     */
    public function getResponse(): DomainResource
    {
        return new DomainResource($this->domain);
    }
}
