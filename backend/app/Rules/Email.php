<?php

declare(strict_types=1);

namespace App\Rules;

use App\Constants\CompanyConstant;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

final class Email implements Rule
{
    private $user;

    /**
     * @param \App\Models\User $user
     */
    public function __construct(\App\Models\User $user)
    {
        $this->user = $user;
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {

        $user = User::where('email', $value)->first();

        if (!isset($user)) {
            return true;
        }

        if ($user->id !== $this->user->id) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'Duplicate email';
    }
}
