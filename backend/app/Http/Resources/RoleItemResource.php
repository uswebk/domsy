<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class RoleItemResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'role_id' => $this->role_id,
            'menu_item_id' => $this->menu_item_id,
        ];
    }
}
