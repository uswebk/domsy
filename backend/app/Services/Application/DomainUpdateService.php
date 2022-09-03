<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Http\Resources\DomainResource;

use Exception;

use Illuminate\Support\Facades\DB;

final class DomainUpdateService
{
    private $domainRepository;

    private $domain;

    /**
     * @param \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
    ) {
        $this->domainRepository = $domainRepository;
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
                'purchased_at' => $domainRequest->purchased_at,
                'expired_at' => $domainRequest->expired_at,
                'canceled_at' => $domainRequest->canceled_at,
            ]);

            $this->domain = $this->domainRepository->save($domain);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    /**
     * @return \App\Http\Resources\DomainResource
     */
    public function getResponseData(): \App\Http\Resources\DomainResource
    {
        return new DomainResource($this->domain);
    }
}
