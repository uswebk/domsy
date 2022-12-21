<?php

namespace Database\Factories;

use App\Models\MailCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class MailCategoryFactory extends Factory
{
    protected $model = MailCategory::class;

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
            'is_specify_number_days' => $this->faker->boolean,
            'default_days' => $this->faker->numberBetween(10, 100),
        ];
    }
}
