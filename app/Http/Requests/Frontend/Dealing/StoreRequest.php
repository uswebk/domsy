<?php

declare(strict_types=1);

namespace App\Http\Requests\Frontend\Dealing;

use App\Http\Requests\Request;
use App\Rules\HasClient;
use App\Rules\Interval;
use App\Services\Application\InputData\DealingStoreRequest;

final class StoreRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'domain_id' => 'required|integer',
            'client_id' => new HasClient(),
            'subtotal' => 'required|integer',
            'discount' => 'nullable|integer',
            'billing_date' => 'required|date_format:Y-m-d|after:yesterday',
            'interval' => 'required|integer',
            'interval_category' => new Interval(),
            'is_auto_update' => 'required|boolean',
            'is_halt' => 'required|boolean',
        ];
    }

    /**
     * @return \App\Services\Application\InputData\DealingStoreRequest
     */
    public function makeInput(): \App\Services\Application\InputData\DealingStoreRequest
    {
        return new DealingStoreRequest($this);
    }
}
