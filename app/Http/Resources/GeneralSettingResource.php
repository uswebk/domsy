<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Infrastructures\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

final class GeneralSettingResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        $user = User::find(Auth::id());

        return [
            'id' => $this->id,
            'name' => $this->name,
            'annotation' => $this->annotation,
            'enabled' => $user->enableGeneralSettingByGeneralId($this->id),
        ];
    }
}
