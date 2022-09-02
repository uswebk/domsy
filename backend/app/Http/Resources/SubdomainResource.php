<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class SubdomainResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'prefix' => $this->prefix,
            'domain_id' => $this->domain_id,
            'type_id' => $this->type_id,
            'full_domain' => $this->getFullDomainName(),
            'dns_record_name' => (isset($this->dnsRecordType)) ? $this->dnsRecordType->name: '',
            'value' => $this->value,
            'ttl' => $this->ttl,
            'priority' => $this->priority,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
