<?php

declare(strict_types=1);

namespace Database\Factories\Infrastructures\Models;

use App\Infrastructures\Models\Menu;
use App\Infrastructures\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use function now;

final class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_id' => Menu::factory(),
            'name' => $this->faker->word,
            'controller' => $this->faker->word,
            'function' => $this->faker->word,
            'route' => $this->faker->word,
            'endpoint' => $this->faker->word,
            'description' => $this->faker->word,
            'is_screen' => $this->faker->boolean,
            'sort' => $this->faker->numberBetween(10, 100),
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
