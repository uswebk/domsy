<?php

declare(strict_types=1);

namespace Database\Factories\Infrastructures\Models;

use App\Infrastructures\Models\DnsRecordType;
use App\Infrastructures\Models\Domain;

use App\Infrastructures\Models\Subdomain;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubdomainFactory extends Factory
{
    protected $model = Subdomain::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'domain_id' => Domain::factory(),
            'prefix' => $this->faker->word,
            'type_id' => DnsRecordType::factory(),
            'value' => $this->faker->boolean,
            'ttl' => $this->faker->randomNumber(3),
            'priority' => $this->faker->randomNumber(2),
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
