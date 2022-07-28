<?php

declare(strict_types=1);

namespace App\Rules;

use App\Constants\CompanyConstant;

use App\Infrastructures\Models\Role;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

final class RoleRequiredAdmin implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if ($value === CompanyConstant::INDEPENDENT_COMPANY_ID) {
            return true;
        }

        $user = Auth::user();
        $role = Role::where('id', '=', CompanyConstant::INDEPENDENT_COMPANY_ID)
        ->where('company_id', '=', $user->company_id)
        ->first();

        return isset($role);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'At least one administrator account is required';
    }
}
