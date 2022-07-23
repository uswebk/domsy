<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Registrar;

use App\Http\Requests\Request;

final class UpdateRequest extends Request
{
    /**
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

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
