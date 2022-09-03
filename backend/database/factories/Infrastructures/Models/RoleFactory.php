<?php

declare(strict_types=1);

namespace Database\Factories\Infrastructures\Models;

use App\Infrastructures\Models\Company;
use App\Infrastructures\Models\Role;

use Illuminate\Database\Eloquent\Factories\Factory;

final class RoleFactory extends Factory
{
    protected $model = Role::class;

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
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
