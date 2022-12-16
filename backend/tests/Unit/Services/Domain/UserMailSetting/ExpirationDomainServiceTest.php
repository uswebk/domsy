<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Domain\UserMailSetting;

use App\Infrastructures\Models\Domain;
use App\Infrastructures\Models\User;
use App\Infrastructures\Models\UserMailSetting;
use App\Services\Domain\UserMailSetting\ExpirationDomainService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ExpirationDomainServiceTest extends TestCase
{
    use RefreshDatabase;

    private const NOTICE_NUMBER_DAYS = 20;

    public function setUp(): void
    {
        parent::setUp();

        $this->now = now();

        $this->user = User::factory()->create();

        $this->userMailSetting = UserMailSetting::factory([
            'user_id' => $this->user->id,
            'notice_number_days' => self::NOTICE_NUMBER_DAYS,
        ])->create();

        $this->domain = Domain::factory([
            'user_id' => $this->user->id,
            'is_active' => true,
            'is_transferred' => false,
            'expired_at' => $this->now->copy()->addDays(self::NOTICE_NUMBER_DAYS)->toDateTimeString(),
        ])->create();

        $this->domainOfNotOwner = Domain::factory([
            'user_id' => $this->user->id,
            'is_active' => false,
            'is_transferred' => true,
            'expired_at' => $this->now->copy()->addDays(self::NOTICE_NUMBER_DAYS)->toDateTimeString(),
        ])->create();
    }

    /**
     * @test
     */
    public function it_get_domains_when_expiration_date_domain_exists(): void
    {
        $domains = (new ExpirationDomainService($this->userMailSetting, $this->user, $this->now))->getDomains();

        $this->assertTrue($domains->contains($this->domain));
        $this->assertFalse($domains->contains($this->domainOfNotOwner));
    }

    /**
     * @test
     */
    public function it_get_domains_when_expiration_date_domain_not_exists(): void
    {
        $domains = (new ExpirationDomainService($this->userMailSetting, $this->user, $this->now->copy()->addDay()))->getDomains();

        $this->assertFalse($domains->contains($this->domain));
    }
}
