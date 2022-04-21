<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Models\Eloquent\Domain;
use App\Infrastructures\Repositories\Domain\DomainRepositoryInterface;
use App\Services\Domain\Domain\HasRegistrarService as DomainHasRegistrarService;

use Illuminate\Support\Facades\Auth;

final class DomainUpdateService
{
    private $domainRepository;

    public function __construct(DomainRepositoryInterface $domainRepository)
    {
        $this->domainRepository = $domainRepository;
    }

    public function handle(
        Domain $domain,
        string $name,
        string $price,
        int $registrar_id,
        string $is_active,
        string $is_transferred,
        string $is_management_only,
        string $purchased_at,
        string $expired_at,
        ?string $canceled_at,
    ) {
        \DB::beginTransaction();
        try {
            $hasRegistrarService = new DomainHasRegistrarService(Auth::id(), $registrar_id);

            if ($hasRegistrarService->execute($registrar_id)) {
                $domain->fill([
                    'name' => $name,
                    'price' => $price,
                    'registrar_id' => $registrar_id,
                    'is_active' => $is_active,
                    'is_transferred' => $is_transferred,
                    'is_management_only' => $is_management_only,
                    'purchased_at' => $purchased_at,
                    'expired_at' => $expired_at,
                    'canceled_at' => $canceled_at,
                ]);

                $this->domainRepository->save($domain);
            }

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }
    }
}
