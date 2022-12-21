<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Models\User;
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

        $this->totalPrice = $eloquentDomainQueryService->getSumOfFixedBillingPriceByUserIds(
            $user->getMemberIds(),
        );
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
