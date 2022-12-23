<?php

declare(strict_types=1);

namespace Tests\Unit\Queries\Domain\Billing;

use App\Models\Domain;
use App\Models\DomainBilling;
use App\Models\DomainDealing;
use App\Queries\Domain\Billing\EloquentBillingQueryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function now;

final class EloquentDomainBillingQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array
     */
    public function dataProviderOfGetValidUnclaimed(): array
    {
        return [
            'match all' => [
                1,
                [
                    [
                        'dealing_id' => 1,
                        'billing_date' => now()->addDay()->toDateTimeString(),
                        'is_fixed' => 0,
                        'canceled_at' => null,
                    ],
                    [
                        'dealing_id' => 1,
                        'billing_date' => now()->addDays(2)->toDateTimeString(),
                        'is_fixed' => 0,
                        'canceled_at' => null,
                    ],
                ],
                2,
            ],
            'not match if is_fixed' => [
                1,
                [
                    [
                        'dealing_id' => 1,
                        'billing_date' => now()->addDay()->toDateTimeString(),
                        'is_fixed' => 0,
                        'canceled_at' => null,
                    ],
                    [
                        'dealing_id' => 1,
                        'billing_date' => now()->addDays(2)->toDateTimeString(),
                        'is_fixed' => 1,
                        'canceled_at' => null,
                    ],
                ],
                1,
            ],
            'not match if over billing date' => [
                1,
                [
                    [
                        'dealing_id' => 1,
                        'billing_date' => now()->addDay()->toDateTimeString(),
                        'is_fixed' => 0,
                        'canceled_at' => null,
                    ],
                    [
                        'dealing_id' => 1,
                        'billing_date' => now()->subDay()->toDateTimeString(),
                        'is_fixed' => 0,
                        'canceled_at' => null,
                    ],
                ],
                1,
            ],
            'not match if is canceled' => [
                1,
                [
                    [
                        'dealing_id' => 1,
                        'billing_date' => now()->addDay()->toDateTimeString(),
                        'is_fixed' => 0,
                        'canceled_at' => null,
                    ],
                    [
                        'dealing_id' => 1,
                        'billing_date' => now()->subDay()->toDateTimeString(),
                        'is_fixed' => 0,
                        'canceled_at' => now()->toDateTimeString(),
                    ],
                ],
                1,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetValidUnclaimed
     */
    public function it_get_valid_unclaimed(
        int $dealingId,
        array $parameterOfBillings,
        int $assertCount
    ): void {
        $domain = Domain::factory()->create();
        DomainDealing::factory(['id' => $dealingId, 'domain_id' => $domain->id])->create();

        foreach ($parameterOfBillings as $parameterOfBilling) {
            DomainBilling::factory($parameterOfBilling)->create();
        }

        $billings = (new EloquentBillingQueryService())->getValidUnclaimed([$domain->user_id], now());

        $this->assertSame($billings->count(), $assertCount);
    }

    public function dataProviderOfGetFixedTotalAmountOfDuringPeriod(): array
    {
        return [
            'match all' => [
                1,
                [
                    [
                        'dealing_id' => 1,
                        'total' => 3000,
                        'billing_date' => now()->addDay()->toDateTimeString(),
                        'is_fixed' => 1,
                        'canceled_at' => null,
                    ],
                    [
                        'dealing_id' => 1,
                        'total' => 3000,
                        'billing_date' => now()->addDays(2)->toDateTimeString(),
                        'is_fixed' => 1,
                        'canceled_at' => null,
                    ],
                ],
                6000,
            ],
            'not match if is not fixed' => [
                1,
                [
                    [
                        'dealing_id' => 1,
                        'total' => 3000,
                        'billing_date' => now()->addDay()->toDateTimeString(),
                        'is_fixed' => 1,
                        'canceled_at' => null,
                    ],
                    [
                        'dealing_id' => 1,
                        'total' => 3000,
                        'billing_date' => now()->addDays(2)->toDateTimeString(),
                        'is_fixed' => 0,
                        'canceled_at' => null,
                    ],
                ],
                3000,
            ],
            'not match if is not target billing date' => [
                1,
                [
                    [
                        'dealing_id' => 1,
                        'total' => 3000,
                        'billing_date' => now()->addDay()->toDateTimeString(),
                        'is_fixed' => 1,
                        'canceled_at' => null,
                    ],
                    [
                        'dealing_id' => 1,
                        'total' => 3000,
                        'billing_date' => now()->subMonths(10)->toDateTimeString(),
                        'is_fixed' => 1,
                        'canceled_at' => null,
                    ],
                ],
                3000,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetFixedTotalAmountOfDuringPeriod
     */
    public function it_get_fixed_total_amount_of_during_period(
        int $dealingId,
        array $parameterOfBillings,
        int $assertAmount
    ): void {
        $domain = Domain::factory()->create();
        DomainDealing::factory(['id' => $dealingId, 'domain_id' => $domain->id])->create();

        foreach ($parameterOfBillings as $parameterOfBilling) {
            DomainBilling::factory($parameterOfBilling)->create();
        }

        $billingAmounts = (new EloquentBillingQueryService())->getFixedTotalAmountOfDuringPeriod(
            [$domain->user_id],
            now()->subMonth(),
            now()->addMonth()
        );

        $billingAmount = $billingAmounts->where('month', now()->format('Y/m'))->first();

        $this->assertEquals($assertAmount, $billingAmount->amount);
    }
}
