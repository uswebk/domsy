<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Exceptions\Client\DomainExistsException;
use App\Services\Domain\Registrar\HasService as RegistrarHasService;

use Exception;

use Illuminate\Support\Facades\DB;

final class DomainStoreService
{
    private $domainRepository;

    private $subdomainRepository;

    private $domainNotExistsService;

    /**
     * @param \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
     * @param \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
     * @param \App\Services\Domain\Domain\NotExistsService $domainNotExistsService
     */
    public function __construct(
        \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository,
        \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository,
        \App\Services\Domain\Domain\NotExistsService $domainNotExistsService
    ) {
        $this->domainRepository = $domainRepository;
        $this->subdomainRepository = $subdomainRepository;
        $this->domainNotExistsService = $domainNotExistsService;
    }

    /**
     * @param string $name
     * @param string $price
     * @param integer $userId
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
        string $name,
        string $price,
        int $userId,
        int $registrarId,
        string $isActive,
        string $isTransferred,
        string $isManagementOnly,
        string $purchasedAt,
        string $expiredAt,
        ?string $canceledAt,
    ) {
        DB::beginTransaction();
        try {
            if (! $this->domainNotExistsService->isNotExists($userId, $name)) {
                throw new DomainExistsException();
            }

            $registrarService = new RegistrarHasService($userId, $registrarId);

            if ($registrarService->isOwner()) {
                $domain = $this->domainRepository->store([
                    'name' => $name,
                    'price' => $price,
                    'user_id' => $userId,
                    'registrar_id' => $registrarId,
                    'is_active' => $isActive,
                    'is_transferred' => $isTransferred,
                    'is_management_only' => $isManagementOnly,
                    'purchased_at' => $purchasedAt,
                    'expired_at' => $expiredAt,
                    'canceled_at' => $canceledAt,
                ]);

                $this->subdomainRepository->store([
                    'domain_id' => $domain->id,
                    'subdomain' => null,
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }
}
