<?php

declare(strict_types=1);

namespace App\Rules;

use App\Infrastructures\Models\Registrar;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

final class RegistrarOwner implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $registrar = Registrar::where('id', '=', $value)->where('user_id', '=', Auth::id())
        ->first();

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
