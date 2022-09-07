<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;

final class FetchTotalSellerService
{
    private $totalPrice;

    /**
     * @param \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
     */
    public function __construct(
        \App\Infrastructures\Queries\Domain\EloquentDomainQueryServiceInterface $eloquentDomainQueryService
    ) {
        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $this->domains = $eloquentDomainQueryService->getByUserIds($user->getMemberIds());
        } else {
            $this->domains = $user->domains;
        }

        $this->totalPrice = 0;
        // TODO: 速度改善
        foreach ($this->domains as $domain) {
            $this->totalPrice += $domain->getTotalSeller();
        }
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return [
            'totalPrice' => $this->totalPrice,
        ];
    }
}
