<?php

declare(strict_types=1);

namespace Database\Factories\Infrastructures\Models;

use App\Infrastructures\Models\Company;

use Illuminate\Database\Eloquent\Factories\Factory;

final class CompanyFactory extends Factory
{
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'zip' => $this->faker->randomNumber(7),
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
