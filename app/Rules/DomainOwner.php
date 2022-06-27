<?php

declare(strict_types=1);

namespace App\Rules;

use App\Infrastructures\Models\Domain;

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
        $domain = Domain::where('id', $value)->where('user_id', Auth::id())
        ->first();

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
