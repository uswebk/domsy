<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;

final class DomainFetchTotalSellerService
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

        foreach ($this->domains as $domain) {
            $this->totalPrice += $domain->getTotalSeller();
        }
    }

    /**
     * @return array
     */
    public function getResponseData(): array
    {
        return [
            'totalPrice' => $this->totalPrice,
        ];
    }
}
