<?php

namespace Database\Factories\Infrastructures\Models;

use App\Infrastructures\Models\GeneralSettingCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeneralSettingCategoryFactory extends Factory
{
    protected $model = GeneralSettingCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'annotation' => $this->faker->word,
            'sort' => $this->faker->numberBetween(10, 100),
        ];
    }
}
