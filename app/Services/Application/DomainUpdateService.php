<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Models\Eloquent\Domain;
use App\Infrastructures\Repositories\Domain\DomainRepositoryInterface;
use App\Services\Domain\Registrar\HasService as RegistrarHasService;

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
            $registrarHasService = new RegistrarHasService(Auth::id(), $registrarId);

            if ($registrarHasService->execute()) {
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
            }

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();

            throw $e;
        }
    }
}
