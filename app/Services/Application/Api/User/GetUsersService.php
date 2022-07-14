<?php

declare(strict_types=1);

namespace App\Services\Application\Api\User;

use App\Infrastructures\Models\User;
use Illuminate\Support\Facades\Auth;

final class GetUsersService
{
    private $user;

    public function __construct(
    ) {
        // TODO: QueryService
        $user = User::find(Auth::id());

        if (! $user->isCompany()) {
            abort(403);
        }

        // TODO: QueryService
        $this->users = User::where('id', '!=', $user->id)
        ->where('company_id', '=', $user->company_id)
        ->whereNull('deleted_at')
        ->get();
    }

    public function getResponse()
    {
        // JsonResource
    }
}
