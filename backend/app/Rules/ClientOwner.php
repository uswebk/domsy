<?php

declare(strict_types=1);

namespace App\Rules;

use App\Infrastructures\Models\Client;

use App\Infrastructures\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

final class ClientOwner implements Rule
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
            $client = Client::where('id', $value)->whereIn('user_id', $user->getMemberIds())
            ->first();
        } else {
            $client = Client::where('id', '=', $value)->where('user_id', '=', $user->id)
            ->first();
        }

        return isset($client);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'Client does not exist';
    }
}
