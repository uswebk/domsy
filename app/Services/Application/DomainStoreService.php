<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Repositories\Domain\DomainRepositoryInterface;
use App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface;
use App\Services\Domain\Domain\NotExistsService as DomainNotExistsService;
use App\Services\Domain\Registrar\HasService as RegistrarHasService;

final class DomainStoreService
{
    private $domainRepository;
    private $subdomainRepository;

    public function __construct(
        DomainRepositoryInterface $domainRepository,
        SubdomainRepositoryInterface $subdomainRepository,
    ) {
        $this->domainRepository = $domainRepository;
        $this->subdomainRepository = $subdomainRepository;
    }

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
        \DB::beginTransaction();
        try {
            $notExistsService = new DomainNotExistsService($userId, $name);
            $registrarHasService = new RegistrarHasService($userId, $registrarId);

            if ($registrarHasService->execute() && $notExistsService->execute()) {
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

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();

            throw $e;
        }
    }
}
