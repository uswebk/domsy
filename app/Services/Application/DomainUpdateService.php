<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Exceptions\Client\NotOwnerException;

use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class DomainUpdateService
{
    private $domainRepository;

    private $registrarHasService;

    /**
     * @param \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
     * @param \App\Services\Domain\Registrar\HasService $registrarHasService
     */
    public function __construct(
        \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository,
        \App\Services\Domain\Registrar\HasService $registrarHasService
    ) {
        $this->domainRepository = $domainRepository;
        $this->registrarHasService = $registrarHasService;
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\Domain $domainRequest
     * @param \App\Infrastructures\Models\Eloquent\Domain $domain
     *
     * @throws NotOwnerException
     *
     * @return void
     */
    public function handle(
        \App\Infrastructures\Models\Eloquent\Domain $domainRequest,
        \App\Infrastructures\Models\Eloquent\Domain $domain
    ): void {
        try {
            if (!$this->registrarHasService->isOwner($domainRequest->registrar_id, Auth::id())) {
                throw new NotOwnerException();
            }
        } catch (NotOwnerException $e) {
            Log::info($e->getMessage());

            throw $e;
        }

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

            $this->domainRepository->save($domain);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }
}
