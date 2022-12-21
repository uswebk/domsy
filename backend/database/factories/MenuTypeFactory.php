<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\MenuType;
use Illuminate\Database\Eloquent\Factories\Factory;

final class MenuTypeFactory extends Factory
{
    protected $model = MenuType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->word,
            'sort' => $this->faker->numberBetween(10, 100),
        ];
    }
}
