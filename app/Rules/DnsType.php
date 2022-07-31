<?php

declare(strict_types=1);

namespace App\Rules;

use App\Infrastructures\Models\DnsRecordType;
use Illuminate\Contracts\Validation\Rule;

final class DnsType implements Rule
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
        $dnsRecordTypes = DnsRecordType::get();
        $dnsRecordTypeIds = $dnsRecordTypes->pluck('id')->toArray();

        return in_array($value, $dnsRecordTypeIds);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'DNS Type is illegal value';
    }
}
