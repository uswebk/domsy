<?php

declare(strict_types=1);

namespace Database\Factories\Infrastructures\Models;

use App\Infrastructures\Models\Domain;
use App\Infrastructures\Models\Registrar;
use App\Infrastructures\Models\User;

use Illuminate\Database\Factories\Factory;

class DomainFactory extends Factory
{
    protected $model = Domain::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'user_id' => User::factory(),
            'registrar_id' => Registrar::factory(),
            'price' => $this->faker->numberBetween(0, 10000),
            'is_active' => $this->faker->boolean,
            'is_transferred' => $this->faker->boolean,
            'is_management_only' => $this->faker->boolean,
            'purchased_at' => now(),
            'expired_at' => $this->faker->dateTimeBetween('now', '+1 year'),
            'canceled_at' => null,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
