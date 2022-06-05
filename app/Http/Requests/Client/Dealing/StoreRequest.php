<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Dealing;

use App\Http\Requests\Request;
use App\Infrastructures\Models\Eloquent\DomainDealing;
use App\Infrastructures\Models\Interval;

use Illuminate\Validation\Rule;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'domain_id' => 'required|integer',
            'client_id' => 'required|integer',
            'subtotal' => 'required|integer',
            'discount' => 'nullable|integer',
            'billing_date' => 'required|date_format:Y-m-d|after:yesterday',
            'interval' => 'required|integer',
            'interval_category' => Rule::in(array_keys(Interval::getIntervalList())),
            'is_auto_update' => 'required|boolean',
            'is_halt' => 'required|boolean',
        ];
    }

    /**
     * @return \App\Infrastructures\Models\Eloquent\DomainDealing
     */
    public function makeDto(): \App\Infrastructures\Models\Eloquent\DomainDealing
    {
        return new DomainDealing($this->validated());
    }
}
