<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Domain;

use App\Infrastructures\Models\Domain;
use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class FetchActiveSummaryService
{
    private $domainSummary;

    public function __construct()
    {
        $user = User::find(Auth::id());
        if ($user->isCompany()) {
            $userIds = $user->getMemberIds();
        } else {
            $userIds = [$user->id];
        }

        // TODO: move QueryService
        $this->domainSummary = Domain::select([
            DB::raw('COUNT(*) AS total'),
            DB::raw('COUNT(CASE WHEN is_active = 1 THEN 1 END) AS active'),
            DB::raw('COUNT(CASE WHEN is_active = 0 THEN 0 END) AS inactive'),
        ])
        ->whereIn('user_id', $userIds)
        ->first();
    }

    /**
     * @return \App\Infrastructures\Models\Domain
     */
    public function getResponse(): \App\Infrastructures\Models\Domain
    {
        return $this->domainSummary;
    }
}
