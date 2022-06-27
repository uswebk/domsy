<?php

namespace App\Rules;

use App\Infrastructures\Models\Client;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

final class HasClient implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $client = Client::where('id', '=', $value)->where('user_id', '=', Auth::id())
        ->first();

        return isset($client);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Client does not exist';
    }
}
