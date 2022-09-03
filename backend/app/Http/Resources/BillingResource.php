<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class BillingResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'total' => $this->total,
            'dealing' => $this->domainDealing,
            'billing_date' => $this->billing_date,
            'is_fixed' => $this->is_fixed,
            'changed_at' => $this->changed_at,
            'domain_name' => $this->getDomainName(),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
