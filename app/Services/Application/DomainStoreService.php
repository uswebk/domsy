<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Repositories\Domain\DomainRepositoryInterface;
use App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface;
use App\Services\Domain\Domain\AlreadyExistsService as DomainAlreadyExistsService;

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
        int $user_id,
        string $is_active,
        string $is_transferred,
        string $is_management_only,
        string $purchased_at,
        string $expired_at,
        ?string $canceled_at,
    ) {
        \DB::beginTransaction();
        try {
            $domainService = new DomainAlreadyExistsService($name, $user_id);
            $notExists = $domainService->isNotExists();

            if ($notExists) {
                $domain = $this->domainRepository->store([
                    'name' => $name,
                    'price' => $price,
                    'user_id' => $user_id,
                    'is_active' => $is_active,
                    'is_transferred' => $is_transferred,
                    'is_management_only' => $is_management_only,
                    'purchased_at' => $purchased_at,
                    'expired_at' => $expired_at,
                    'canceled_at' => $canceled_at,
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
