<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Registrar;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

final class RegistrarOwner implements Rule
{
    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $user = User::find(Auth::id());

        if ($user->isCompany()) {
            $registrar = Registrar::where('id', '=', $value)
                ->whereIn('user_id', $user->getMemberIds())
                ->first();
        } else {
            $registrar = Registrar::where('id', '=', $value)->where('user_id', '=', Auth::id())
                ->first();
        }

        return isset($registrar);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'Registrar does not exist';
    }
}
