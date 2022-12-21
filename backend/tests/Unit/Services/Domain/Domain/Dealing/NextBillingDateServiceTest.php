<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Domain\Domain\Dealing;

use App\Models\DomainBilling;
use App\Models\DomainDealing;
use App\Services\Domain\Domain\Dealing\NextBillingDateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class NextBillingDateServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_get_next_when_interval_year(): void
    {
        $interval = 1;
        $domainDealing = DomainDealing::factory([
            'interval' => $interval,
            'interval_category' => 'YEAR',
        ])->create();

        DomainBilling::factory(([
            'dealing_id' => $domainDealing->id,
            'billing_date' => now()->toDateString(),
            'is_auto' => true,
            'is_fixed' => false,
        ]))->create();

        $nextDate = (new NextBillingDateService($domainDealing))->getNext();

        $this->assertEquals($nextDate, now()->startOfDay()->addYears($interval));
    }

    /** @test */
    public function it_get_next_when_interval_month(): void
    {
        $interval = 1;
        $domainDealing = DomainDealing::factory([
            'interval' => $interval,
            'interval_category' => 'MONTH',
        ])->create();

        DomainBilling::factory(([
            'dealing_id' => $domainDealing->id,
            'billing_date' => now()->toDateString(),
            'is_auto' => true,
            'is_fixed' => false,
        ]))->create();

        $nextDate = (new NextBillingDateService($domainDealing, now()))->getNext();

        $this->assertEquals($nextDate, now()->startOfDay()->addMonths($interval));
    }

    /** @test */
    public function it_get_next_when_interval_week(): void
    {
        $interval = 1;
        $domainDealing = DomainDealing::factory([
            'interval' => $interval,
            'interval_category' => 'WEEK',
        ])->create();

        DomainBilling::factory(([
            'dealing_id' => $domainDealing->id,
            'billing_date' => now()->toDateString(),
            'is_auto' => true,
            'is_fixed' => false,
        ]))->create();

        $nextDate = (new NextBillingDateService($domainDealing, now()))->getNext();

        $this->assertEquals($nextDate, now()->startOfDay()->addWeeks($interval));
    }

    /** @test */
    public function it_get_next_when_interval_day(): void
    {
        $interval = 1;
        $domainDealing = DomainDealing::factory([
            'interval' => $interval,
            'interval_category' => 'DAY',
        ])->create();

        DomainBilling::factory(([
            'dealing_id' => $domainDealing->id,
            'billing_date' => now()->toDateString(),
            'is_auto' => true,
            'is_fixed' => false,
        ]))->create();

        $nextDate = (new NextBillingDateService($domainDealing, now()))->getNext();

        $this->assertEquals($nextDate, now()->startOfDay()->addDays($interval));
    }
}
