<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Account;

use App\Http\Requests\Request;
use App\Rules\Email;
use App\Rules\RoleOwner;
use App\Rules\RoleRequiredAdmin;

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
            'email' => ['email','max:255',new Email($this->user)],
            'role_id' => [new RoleOwner(), new RoleRequiredAdmin($this->user)],
        ];
    }

    /**
     * @return array
     */
    public function makeInput(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ];
    }
}
