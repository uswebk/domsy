<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Models\User;
use App\Queries\Domain\DomainQueryServiceInterface;
use Illuminate\Support\Facades\Auth;

final class FetchTotalSellerService
{
    private int $totalPrice;

    /**
     * @param DomainQueryServiceInterface $domainQueryService
     */
    public function __construct(DomainQueryServiceInterface $domainQueryService)
    {
        $user = User::find(Auth::id());

        $this->totalPrice = $domainQueryService->getSumOfFixedBillingPriceByUserIds($user->getMemberIds());
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return ['totalPrice' => $this->totalPrice,];
    }
}
