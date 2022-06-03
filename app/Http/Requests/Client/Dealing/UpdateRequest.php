<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Dealing;

use App\Http\Requests\Request;
use App\Infrastructures\Models\Eloquent\DomainDealing;
use App\Infrastructures\Models\Interval;

use Illuminate\Validation\Rule;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'subtotal' => 'required|integer',
            'discount' => 'required|integer',
            'interval' => 'required|integer',
            'interval_category' => Rule::in(array_keys(Interval::getIntervalList())),
            'is_auto_update' => 'required|boolean',
        ];
    }

    /**
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function withValidator(
        \Illuminate\Contracts\Validation\Validator $validator
    ): \Illuminate\Contracts\Validation\Validator {
        $validator->sometimes('domain_id', 'required|integer', function ($input) {
            $domainDealing = $this->route()->parameter('domainDealing');

            return $domainDealing->isUnclaimed();
        });

        $validator->sometimes('client_id', 'required|integer', function ($input) {
            $domainDealing = $this->route()->parameter('domainDealing');

            return $domainDealing->isUnclaimed();
        });

        $validator->sometimes('billing_date', 'required|date_format:Y-m-d|after:yesterday', function ($input) {
            $domainDealing = $this->route()->parameter('domainDealing');

            return $domainDealing->isUnclaimed();
        });

        return $validator;
    }

    /**
     * @return \App\Infrastructures\Models\Eloquent\DomainDealing
     */
    public function makeDto(): \App\Infrastructures\Models\Eloquent\DomainDealing
    {
        $validated = $this->validated();

        return new DomainDealing($validated);
    }
}
