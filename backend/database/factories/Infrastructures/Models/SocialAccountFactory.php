<?php

declare(strict_types=1);

namespace Database\Factories\Infrastructures\Models;

use App\Infrastructures\Models\Company;

use App\Infrastructures\Models\SocialAccount;
use App\Infrastructures\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class SocialAccountFactory extends Factory
{
    protected $model = SocialAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'provider_id' => $this->faker->word,
            'provider_name' => $this->faker->word,
            'avatar_path' => $this->faker->imageUrl,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
