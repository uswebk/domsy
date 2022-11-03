<?php

declare(strict_types=1);

namespace Database\Factories\Infrastructures\Models;

use App\Infrastructures\Models\GeneralSettingCategory;
use App\Infrastructures\Models\User;
use App\Infrastructures\Models\UserGeneralSetting;

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
