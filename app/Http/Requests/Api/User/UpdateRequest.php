<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\User;

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
            'name' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users', //TODO: 自分以外の重複Check Rule
            'role_id' => 'required|integer', // TODO: Rule 所有ロール以外省く
        ];
    }
}
