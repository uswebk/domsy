<?php

declare(strict_types=1);

namespace App\Http\Requests\Frontend\Dealing;

use App\Http\Requests\Request;
use App\Services\Application\InputData\DealingStoreRequest;

final class StoreRequest extends Request
{
    private $hasClientRule;

    private $intervalRule;

    /**
     * @param \App\Rules\HasClient $hasClientRule
     * @param \App\Rules\Interval $intervalRule
     */
    public function __construct(
        \App\Rules\HasClient $hasClientRule,
        \App\Rules\Interval $intervalRule
    ) {
        $this->hasClientRule = $hasClientRule;
        $this->intervalRule = $intervalRule;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'domain_id' => 'required|integer',
            'client_id' => $this->hasClientRule,
            'subtotal' => 'required|integer',
            'discount' => 'nullable|integer',
            'billing_date' => 'required|date_format:Y-m-d|after:yesterday',
            'interval' => 'required|integer',
            'interval_category' => $this->intervalRule,
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
