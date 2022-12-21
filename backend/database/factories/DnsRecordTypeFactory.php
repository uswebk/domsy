<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\DnsRecordType;
use Illuminate\Database\Eloquent\Factories\Factory;

final class DnsRecordTypeFactory extends Factory
{
    protected $model = DnsRecordType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'sort' => $this->faker->randomNumber(3),
        ];
    }
}
