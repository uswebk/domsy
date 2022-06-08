<?php

declare(strict_types=1);

namespace App\Http\Requests\Frontend\Registrar;

use App\Http\Requests\Request;

final class UpdateRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'link' => 'nullable|string',
            'note' => 'nullable|string',
        ];
    }

    /**
     * @return array
     */
    public function makeInput(): array
    {
        return [
            'name' => $this->name,
            'link' => $this->link ?? '',
            'note' => $this->note ?? '',
        ];
    }
}
