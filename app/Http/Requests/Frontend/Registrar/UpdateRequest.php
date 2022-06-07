<?php

declare(strict_types=1);

namespace App\Http\Requests\Frontend\Registrar;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'link' => 'nullable|string',
            'note' => 'nullable|string',
        ];
    }
}
