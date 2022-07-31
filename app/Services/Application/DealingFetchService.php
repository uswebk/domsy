<?php

declare(strict_types=1);

namespace App\Services\Application;

use App\Http\Resources\DealingResource;
use App\Infrastructures\Models\Domain;
use App\Infrastructures\Models\User;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

final class DealingFetchService
{
    private $domains;

    public function __construct()
    {
        $user = User::find(Auth::id());

        $this->domains = new Collection();

        if ($user->isCompany()) {
            //TODO: Query Service
            $domains = Domain::whereIn('user_id', $user->getMemberIds())->get();
        } else {
            $domains = $user->domains;
        }

        $domains->load([
            'domainDealings',
            'domainDealings.client',
        ]);

        foreach ($domains as $domain) {
            if ($domain->domainDealings->isEmpty()) {
                continue;
            }

            $this->domains->push($domain);
        }
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getResponseData(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return DealingResource::collection($this->domains);
    }
}
