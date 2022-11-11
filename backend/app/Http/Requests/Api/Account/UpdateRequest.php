<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Account;

use App\Http\Requests\Request;
use App\Rules\Email;
use App\Rules\RoleOwner;
use App\Rules\RoleRequiredAdmin;
use Illuminate\Support\Facades\Hash;

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
            'email' => ['email', 'max:255', new Email($this->user)],
            'role_id' => [new RoleOwner(), new RoleRequiredAdmin($this->user)],
        ];
    }

    /**
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     */
    public function withValidator(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        $validator->sometimes('password', 'required|min:8|confirmed', function ($input) {
            return array_key_exists('password', $input->toArray());
        });
    }

    /**
     * @return array
     */
    public function makeInput(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ];

        if (isset($this->password)) {
            $data = array_merge($data, ['password' => Hash::make($this->password),]);
        }

        return $data;
    }
}
