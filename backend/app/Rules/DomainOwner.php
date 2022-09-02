<?php

declare(strict_types=1);

namespace App\Rules;

use App\Infrastructures\Models\Domain;
use App\Infrastructures\Models\User;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

final class DomainOwner implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $domain = Domain::where('id', $value)->whereIn('user_id', $user->getMemberIds())
            ->first();
        } else {
            $domain = Domain::where('id', $value)->where('user_id', $user->id)
            ->first();
        }

        return isset($domain);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'Domain does not exist';
    }
}
