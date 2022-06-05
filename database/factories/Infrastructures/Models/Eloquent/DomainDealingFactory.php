<?php

declare(strict_types=1);

namespace Database\Factories\Infrastructures\Models\Eloquent;

use App\Infrastructures\Models\Eloquent\Client;

use App\Infrastructures\Models\Eloquent\Domain;
use App\Infrastructures\Models\Eloquent\DomainDealing;
use Illuminate\Database\Eloquent\Factories\Factory;

class DomainDealingFactory extends Factory
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
            'interval_category' => 'YEAR',
            'is_auto_update' => true,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
