<?php

declare(strict_types=1);

namespace Database\Factories\Infrastructures\Models\Eloquent;

use App\Infrastructures\Models\Eloquent\DomainBilling;
use App\Infrastructures\Models\Eloquent\DomainDealing;
use Illuminate\Database\Eloquent\Factories\Factory;

class DomainBillingFactory extends Factory
{
    protected $model = DomainBilling::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'dealing_id' => DomainDealing::factory(),
            'total' => $this->faker->numberBetween(0, 10000),
            'billing_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'is_fixed' => true,
            'changed_at' => null,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
