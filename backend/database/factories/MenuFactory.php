<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Menu;
use App\Models\MenuType;
use Illuminate\Database\Eloquent\Factories\Factory;

final class MenuFactory extends Factory
{
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type_id' => MenuType::factory(),
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'icon' => $this->faker->word,
            'is_nav' => $this->faker->boolean,
            'sort' => $this->faker->numberBetween(10, 100),
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
