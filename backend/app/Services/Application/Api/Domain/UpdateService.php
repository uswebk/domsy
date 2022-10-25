<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Http\Resources\DomainResource;


use Exception;
use Illuminate\Support\Facades\DB;

final class UpdateService
{
    private $renewService;

    private $domain;

    /**
     * @param \App\Services\Domain\Domain\RenewService $renewService
     */
    public function __construct(
        \App\Services\Domain\Domain\RenewService $renewService,
    ) {
        $this->renewService = $renewService;
    }

    /**
     * @param \App\Services\Application\InputData\DomainUpdateRequest $domainUpdateRequest
     * @param \App\Infrastructures\Models\Domain $domain
     *
     * @return void
     */
    public function handle(
        \App\Services\Application\InputData\DomainUpdateRequest $domainUpdateRequest,
        \App\Infrastructures\Models\Domain $domain
    ): void {
        $domainRequest = $domainUpdateRequest->getInput();

        DB::beginTransaction();
        try {
            $domain->fill([
                'name' => $domainRequest->name,
                'price' => $domainRequest->price,
                'registrar_id' => $domainRequest->registrar_id,
                'is_active' => $domainRequest->is_active,
                'is_transferred' => $domainRequest->is_transferred,
                'is_management_only' => $domainRequest->is_management_only,
                'is_fetching_dns' => $domainRequest->is_fetching_dns,
                'purchased_at' => $domainRequest->purchased_at,
                'expired_at' => $domainRequest->expired_at,
                'canceled_at' => $domainRequest->canceled_at,
            ]);

            $this->domain = $this->renewService->execute($domain);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    /**
     * @return \App\Http\Resources\DomainResource
     */
    public function getResponse(): \App\Http\Resources\DomainResource
    {
        return new DomainResource($this->domain);
    }
}
