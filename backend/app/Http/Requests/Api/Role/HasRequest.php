<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Role;

use App\Http\Requests\Request;

final class HasRequest extends Request
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
            'menu_id' => 'required|integer',
        ];
    }
}
