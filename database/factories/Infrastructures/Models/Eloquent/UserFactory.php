<?php

declare(strict_types=1);

namespace Database\Factories\Infrastructures\Models\Eloquent;

use App\Infrastructures\Models\Eloquent\Company;
use App\Infrastructures\Models\Eloquent\Role;
use App\Infrastructures\Models\Eloquent\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'company_id' => Company::factory(),
            'role_id' => Role::factory(),
            'code' => $this->faker->randomNumber(5),
            'email' => $this->faker->unique()->safeEmail,
            'email_verify_token' => Str::random(10),
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random(10)),
            'remember_token' => Str::random(10),
            'deleted_at' => null,
            'updated_at' => now(),
            'created_at' => now(),

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
