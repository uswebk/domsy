<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\GeneralSettingCategory;
use App\Models\User;
use App\Models\UserGeneralSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserGeneralSettingFactory extends Factory
{
    protected $model = UserGeneralSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'general_id' => GeneralSettingCategory::factory(),
            'enabled' => $this->faker->boolean,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
