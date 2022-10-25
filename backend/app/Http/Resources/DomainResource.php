<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class DomainResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'registrar_id' => $this->registrar_id,
            'registrar' => new RegistrarResource($this->registrar),
            'is_active' => $this->is_active,
            'is_transferred' => $this->is_transferred,
            'is_management_only' => $this->is_management_only,
            'is_fetching_dns' => $this->is_fetching_dns,
            'purchased_at' => $this->purchased_at,
            'expired_at' => $this->expired_at,
            'canceled_at' => $this->canceled_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
