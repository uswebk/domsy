<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class DomainDealingResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'domain_id' => $this->domain_id,
            'client_id' => $this->client_id,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'billing_date' => $this->billing_date,
            'next_billing' => $this->getNextBilling(),
            'interval' => $this->interval,
            'interval_category' => $this->interval_category,
            'is_auto_update' => $this->is_auto_update,
            'is_halt' => $this->is_halt,
            'has_fixed_billing' => $this->hasFixedBilling(),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'client' => new ClientResource($this->client),
            'domain' => new DomainResource($this->domain),
            'domain_billings' => BillingResource::collection($this->domainBillings),
        ];
    }
}
