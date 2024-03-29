<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->company,
            'email' => $this->faker->safeEmail,
            'zip' => $this->faker->randomNumber(7),
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
