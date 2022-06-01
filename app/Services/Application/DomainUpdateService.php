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
     * @param \App\Infrastructures\Models\Eloquent\Domain $domain
     * @param string $name
     * @param string $price
     * @param integer $registrarId
     * @param string $isActive
     * @param string $isTransferred
     * @param string $isManagementOnly
     * @param string $purchasedAt
     * @param string $expiredAt
     * @param string|null $canceledAt
     * @return void
     */
    public function handle(
        \App\Infrastructures\Models\Eloquent\Domain $domain,
        string $name,
        string $price,
        int $registrarId,
        string $isActive,
        string $isTransferred,
        string $isManagementOnly,
        string $purchasedAt,
        string $expiredAt,
        ?string $canceledAt,
    ) {
        try {
            if (!$this->registrarHasService->isOwner($registrarId, Auth::id())) {
                throw new NotOwnerException();
            }
        } catch (NotOwnerException $e) {
            Log::info($e->getMessage());

            throw $e;
        }

        DB::beginTransaction();
        try {
            $domain->fill([
                'name' => $name,
                'price' => $price,
                'registrar_id' => $registrarId,
                'is_active' => $isActive,
                'is_transferred' => $isTransferred,
                'is_management_only' => $isManagementOnly,
                'purchased_at' => $purchasedAt,
                'expired_at' => $expiredAt,
                'canceled_at' => $canceledAt,
            ]);

            $this->domainRepository->save($domain);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }
}
