<?php

declare(strict_types=1);

namespace Database\Factories\Infrastructures\Models;

use App\Infrastructures\Models\Registrar;
use App\Infrastructures\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class RegistrarFactory extends Factory
{
    protected $model = Registrar::class;

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
            'link' => $this->faker->url,
            'note' => $this->faker->text,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
