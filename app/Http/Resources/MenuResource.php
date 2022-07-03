<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

final class MenuResource extends JsonResource
{
    /**
     * @param [type] $request
     * @return array
     */
    public function toArray($request): array
    {
        $menuItems = new Collection();

        foreach ($this->menuItems as $menuItem) {
            $menuItem->route_name = route($menuItem->route);

            $menuItems->push($menuItem);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'menu_items' => $menuItems->toArray(),
        ];
    }
}
