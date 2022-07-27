<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class MenuItemResource extends JsonResource
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
            'menu_name' => $this->menu->name,
            'icon' => $this->menu->icon,
            'route' => $this->route,
            'route_name' => route($this->route),
            'description' => $this->description,
            'is_screen' => $this->is_screen,
            'sort' => $this->sort,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
