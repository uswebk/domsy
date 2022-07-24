<?php

declare(strict_types=1);

namespace Database\Factories\Infrastructures\Models;

use App\Enums\Interval;
use App\Infrastructures\Models\Client;

use App\Infrastructures\Models\Domain;
use App\Infrastructures\Models\DomainDealing;
use Illuminate\Database\Eloquent\Factories\Factory;

final class DomainDealingFactory extends Factory
{
    protected $model = DomainDealing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'domain_id' => Domain::factory(),
            'client_id' => Client::factory(),
            'subtotal' => $this->faker->numberBetween(0, 10000),
            'discount' => $this->faker->numberBetween(0, 10000),
            'billing_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'interval' => $this->faker->numberBetween(0, 365),
            'interval_category' => Interval::YEAR->value,
            'is_auto_update' => true,
            'is_halt' => true,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
