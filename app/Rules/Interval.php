<?php

declare(strict_types=1);

namespace App\Rules;

use App\Enums\Interval as EnumsInterval;

use Illuminate\Contracts\Validation\Rule;

final class Interval implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach (EnumsInterval::cases() as $interval) {
            if ($interval->name === $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'interval category is illegal value';
    }
}
