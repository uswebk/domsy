<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Infrastructures\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

final class UserMailSettingResource extends JsonResource
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
            'is_received' => $user->isReceivedMailByMailCategoryId($this->id),
            'has_days' => $this->is_specify_number_days,
            'notice_number_days' => $user->getMailSettingNoticeNumberDaysByMailCategoryId($this->id),
        ];
    }
}
