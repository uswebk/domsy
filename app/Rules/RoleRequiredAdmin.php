<?php

declare(strict_types=1);

namespace App\Rules;

use App\Constants\CompanyConstant;

use App\Infrastructures\Models\User;
use Illuminate\Contracts\Validation\Rule;

final class RoleRequiredAdmin implements Rule
{
    private $user;

    /**
     * @param \App\Infrastructures\Models\User $user
     */
    public function __construct(\App\Infrastructures\Models\User $user)
    {
        $this->user = $user;
    }

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

        $user = User::where('id', '!=', $this->user->id)
        ->where('role_id', '=', CompanyConstant::INDEPENDENT_COMPANY_ID)
        ->where('company_id', '=', $this->user->company_id)
        ->whereNull('deleted_at')
        ->first();

        return isset($user);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'At least one administrator account is required';
    }
}
