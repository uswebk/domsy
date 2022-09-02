<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Infrastructures\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Support\Facades\Auth;

final class MenuItemResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        $user = User::find(Auth::id());

        try {
            $routeName = route($this->route);
        } catch (UrlGenerationException $e) {
            $routeName = '';
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'menu_name' => $this->menu->name,
            'icon' => $this->menu->icon,
            'route' => $this->route,
            'route_name' => $routeName,
            'description' => $this->description,
            'is_screen' => $this->is_screen,
            'has_role' => $user->hasRoleItem($this->route),
            'sort' => $this->sort,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
