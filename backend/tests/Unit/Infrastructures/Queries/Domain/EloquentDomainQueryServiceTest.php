<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Queries\Domain;

use App\Infrastructures\Models\Domain;
use App\Infrastructures\Models\DomainBilling;
use App\Infrastructures\Models\DomainDealing;
use App\Infrastructures\Models\User;
use App\Infrastructures\Queries\Domain\EloquentDomainQueryService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function now;

final class EloquentDomainQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array
     */
    public function dataProviderOfGetByUserIds(): array
    {
        return [
            'user_ids_match_domains' => [
                [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                    ],
                    [
                        'id' => 2,
                        'user_id' => 2,
                    ],
                ],
                [1, 2,],
                2,
            ],
            'user_ids_not_match_domains' => [
                [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                    ],
                    [
                        'id' => 2,
                        'user_id' => 2,
                    ],
                ],
                [3, 4,],
                0,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetByUserIds
     */
    public function it_get_by_user_ids(
        array $parameterOfUsers,
        array $parameterOfDomains,
        array $userIds,
        int $count
    ): void {
        foreach ($parameterOfUsers as $parameterOfUser) {
            User::factory($parameterOfUser)->create();
        }

        foreach ($parameterOfDomains as $parameterOfDomain) {
            Domain::factory($parameterOfDomain)->create();
        }

        $domains = (new EloquentDomainQueryService())->getByUserIds($userIds);

        $this->assertCount($count, $domains);
    }

    /**
     * @return array
     */
    public function dataProviderOfGetActiveByUserIdsGraterThanExpiredAtOrderByExpiredAt(): array
    {
        return [
            'case_of_all_match_domains' => [
                [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                        'is_active' => true,
                        'is_transferred' => false,
                        'canceled_at' => null,
                        'expired_at' => now()->addDay()->toDateString(),
                    ],
                    [
                        'id' => 2,
                        'user_id' => 2,
                        'is_active' => true,
                        'is_transferred' => false,
                        'canceled_at' => null,
                        'expired_at' => now()->addDay()->toDateString(),
                    ],
                ],
                [1, 2,],
                2,
            ],
            'case_of_user_id_not_match_domains' => [
                [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                        'is_active' => true,
                        'is_transferred' => false,
                        'canceled_at' => null,
                        'expired_at' => now()->addDay()->toDateString(),
                    ],
                    [
                        'id' => 2,
                        'user_id' => 2,
                        'is_active' => true,
                        'is_transferred' => false,
                        'canceled_at' => null,
                        'expired_at' => now()->addDay()->toDateString(),
                    ],
                ],
                [3, 4,],
                0,
            ],
            'case_of_is_active_not_match_domains' => [
                [
                    [
                        'id' => 1,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                        'is_active' => false,
                        'is_transferred' => false,
                        'canceled_at' => null,
                        'expired_at' => now()->addDay()->toDateString(),
                    ],
                ],
                [1,],
                0,
            ],
            'case_of_is_transferred_not_match_domains' => [
                [
                    [
                        'id' => 1,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                        'is_active' => true,
                        'is_transferred' => true,
                        'canceled_at' => null,
                        'expired_at' => now()->addDay()->toDateString(),
                    ],
                ],
                [1,],
                0,
            ],
            'case_of_canceled_at_not_match_domains' => [
                [
                    [
                        'id' => 1,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                        'is_active' => true,
                        'is_transferred' => false,
                        'canceled_at' => now(),
                        'expired_at' => now()->addDay()->toDateString(),
                    ],
                ],
                [1,],
                0,
            ],
            'case_of_expired_at_not_match_domains' => [
                [
                    [
                        'id' => 1,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                        'is_active' => true,
                        'is_transferred' => false,
                        'canceled_at' => now(),
                        'expired_at' => now()->subDay()->toDateString(),
                    ],
                ],
                [1,],
                0,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetActiveByUserIdsGraterThanExpiredAtOrderByExpiredAt
     */
    public function it_get_active_by_user_ids_grater_than_expired_at_order_by_expired_at(
        array $parameterOfUsers,
        array $parameterOfDomains,
        array $userIds,
        int $count
    ) {
        foreach ($parameterOfUsers as $parameterOfUser) {
            User::factory($parameterOfUser)->create();
        }

        foreach ($parameterOfDomains as $parameterOfDomain) {
            Domain::factory($parameterOfDomain)->create();
        }

        $domains = (new EloquentDomainQueryService())->getActiveByUserIdsGraterThanExpiredAtOrderByExpiredAt(
            $userIds,
            now(),
            10
        );

        $this->assertCount($count, $domains);
    }

    /**
     * @return array
     */
    public function dataProviderOfGetActiveCountByUserIds(): array
    {
        return [
            'match_domains' => [
                [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                        'is_active' => true,
                    ],
                    [
                        'id' => 2,
                        'user_id' => 2,
                        'is_active' => false,
                    ],
                ],
                [1, 2,],
                2,
                1,
                1,
            ],
            'user_id_not_match_domains' => [
                [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                        'is_active' => true,
                    ],
                    [
                        'id' => 2,
                        'user_id' => 2,
                        'is_active' => false,
                    ],
                ],
                [3, 4,],
                0,
                0,
                0,
            ],
            'inactive_not_exits' => [
                [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                        'is_active' => true,
                    ],
                    [
                        'id' => 2,
                        'user_id' => 2,
                        'is_active' => true,
                    ],
                ],
                [1, 2,],
                2,
                2,
                0,
            ],
            'active_not_exits' => [
                [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                        'is_active' => false,
                    ],
                    [
                        'id' => 2,
                        'user_id' => 2,
                        'is_active' => false,
                    ],
                ],
                [1, 2,],
                2,
                0,
                2,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetActiveCountByUserIds
     */
    public function it_get_active_count_by_user_ids(
        array $parameterOfUsers,
        array $parameterOfDomains,
        array $userIds,
        int $assertTotalCount,
        int $assertActiveCount,
        int $assertInactiveCount,
    ) {
        foreach ($parameterOfUsers as $parameterOfUser) {
            User::factory($parameterOfUser)->create();
        }

        foreach ($parameterOfDomains as $parameterOfDomain) {
            Domain::factory($parameterOfDomain)->create();
        }

        $summaries = (new EloquentDomainQueryService())->getActiveCountByUserIds($userIds);

        $this->assertSame($assertTotalCount, $summaries->total);
        $this->assertSame($assertActiveCount, $summaries->active);
        $this->assertSame($assertInactiveCount, $summaries->inactive);
    }

    /**
     * @return array
     */
    public function dataProviderOfGetSumOfFixedBillingPriceByUserIds(): array
    {
        return [
            'match_billings' => [
                [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                    ],
                    [
                        'id' => 2,
                        'user_id' => 2,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'domain_id' => 1,
                    ],
                    [
                        'id' => 2,
                        'domain_id' => 2,
                    ],
                ],
                [
                    [
                        'dealing_id' => 1,
                        'total' => 100,
                        'is_fixed' => true,
                        'canceled_at' => null,
                    ],
                    [
                        'dealing_id' => 2,
                        'total' => 100,
                        'is_fixed' => true,
                        'canceled_at' => null,
                    ],
                    [
                        'dealing_id' => 2,
                        'total' => 100,
                        'is_fixed' => false,
                        'canceled_at' => null,
                    ],
                    [
                        'dealing_id' => 2,
                        'total' => 100,
                        'is_fixed' => true,
                        'canceled_at' => now()->toDateString(),
                    ],
                ],
                [1, 2,],
                200,
            ],
            'not_match_billings' => [
                [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'user_id' => 1,
                    ],
                    [
                        'id' => 2,
                        'user_id' => 2,
                    ],
                ],
                [
                    [
                        'id' => 1,
                        'domain_id' => 1,
                    ],
                    [
                        'id' => 2,
                        'domain_id' => 2,
                    ],
                ],
                [
                    [
                        'dealing_id' => 1,
                        'total' => 100,
                        'is_fixed' => true,
                        'canceled_at' => null,
                    ],
                    [
                        'dealing_id' => 2,
                        'total' => 100,
                        'is_fixed' => true,
                        'canceled_at' => null,
                    ],
                ],
                [3, 4,],
                0,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetSumOfFixedBillingPriceByUserIds
     */
    public function it_get_sum_of_fixed_billing_price_by_user_ids(
        array $parameterOfUsers,
        array $parameterOfDomains,
        array $parameterOfDomainDealings,
        array $parameterOfDomainBillings,
        array $userIds,
        int $assertPrice,
    ) {
        foreach ($parameterOfUsers as $parameterOfUser) {
            User::factory($parameterOfUser)->create();
        }

        foreach ($parameterOfDomains as $parameterOfDomain) {
            Domain::factory($parameterOfDomain)->create();
        }

        foreach ($parameterOfDomainDealings as $parameterOfDealing) {
            DomainDealing::factory($parameterOfDealing)->create();
        }

        foreach ($parameterOfDomainBillings as $parameterOfDomainBilling) {
            DomainBilling::factory($parameterOfDomainBilling)->create();
        }

        $price = (new EloquentDomainQueryService())->getSumOfFixedBillingPriceByUserIds($userIds);

        $this->assertSame($assertPrice, $price);
    }

    /**
     * @return array
     */
    public function dataProviderOfGetCountOfActiveByUserIdsBetweenPurchasedAt(): array
    {
        return [
            'match_domains' => [
                [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
                [
                    [
                        'user_id' => 1,
                        'is_active' => true,
                        'is_transferred' => false,
                        'canceled_at' => null,
                        'purchased_at' => '2022-11-01',
                    ],
                    [
                        'user_id' => 2,
                        'is_active' => true,
                        'is_transferred' => false,
                        'canceled_at' => null,
                        'purchased_at' => '2022-11-30',
                    ],
                    [
                        'user_id' => 2,
                        'is_active' => true,
                        'is_transferred' => false,
                        'canceled_at' => null,
                        'purchased_at' => '2022-12-01',
                    ],
                    [
                        'user_id' => 2,
                        'is_active' => false,
                        'is_transferred' => false,
                        'canceled_at' => null,
                        'purchased_at' => '2022-11-15',
                    ],
                    [
                        'user_id' => 2,
                        'is_active' => true,
                        'is_transferred' => true,
                        'canceled_at' => now()->toDateString(),
                        'purchased_at' => '2022-11-20',
                    ],
                ],
                [1, 2,],
                2,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetCountOfActiveByUserIdsBetweenPurchasedAt
     */
    public function it_get_count_of_active_by_user_ids_between_purchased_at(
        array $parameterOfUsers,
        array $parameterOfDomains,
        array $userIds,
        int $assertCount
    ) {
        foreach ($parameterOfUsers as $parameterOfUser) {
            User::factory($parameterOfUser)->create();
        }

        foreach ($parameterOfDomains as $parameterOfDomain) {
            Domain::factory($parameterOfDomain)->create();
        }

        $month = (new EloquentDomainQueryService())->getCountOfActiveByUserIdsBetweenPurchasedAt(
            $userIds,
            new Carbon('2022-11-01'),
            new Carbon('2022-11-30')
        );

        $this->assertSame($assertCount, $month['2022/11']['count']);
    }
}
