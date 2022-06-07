<?php

declare(strict_types=1);

namespace App\Http\Requests\Frontend\Registrar;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'link' => 'nullable|string',
            'note' => 'nullable|string',
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
        ]);
    }
}
