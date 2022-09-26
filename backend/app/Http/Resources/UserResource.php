<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class UserResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'role_id' => $this->role_id,
            'company_id' => $this->company_id,
            'is_company' => $this->isCompany(),
            'company' => new CompanyResource($this->company),
            'name' => $this->name,
            'email' => $this->email,
            'emoji' => $this->emoji,
            'role' => new RoleResource($this->role),
            'email_verified_at' => $this->email_verified_at,
            'last_login_at' => $this->last_login_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
