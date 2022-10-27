<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Models;

use App\Constants\MailCategoryConstant;
use App\Infrastructures\Models\DnsRecordType;
use App\Infrastructures\Models\Domain;
use App\Infrastructures\Models\MailCategory;
use App\Infrastructures\Models\Subdomain;
use App\Infrastructures\Models\UserMailSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class UserMailSettingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_mail_category()
    {
        $userMailSetting = UserMailSetting::factory()->for(MailCategory::factory())->create();

        $this->assertTrue($userMailSetting->mailCategory()->exists());
    }

    /** @test */
    public function it_is_domain_expiration()
    {
        $userMailSetting = UserMailSetting::factory()->for(MailCategory::factory([
            'name' => MailCategoryConstant::DOMAIN_EXPIRATION_NAME,
        ]))->create();

        $this->assertTrue($userMailSetting->isDomainExpiration());
    }

    /** @test */
    public function it_is_not_domain_expiration()
    {
        $userMailSetting = UserMailSetting::factory()->for(MailCategory::factory([
            'name' => '',
        ]))->create();

        $this->assertFalse($userMailSetting->isDomainExpiration());
    }

    /** @test */
    public function it_is_rejection()
    {
        $userMailSetting = UserMailSetting::factory(['is_received' => false])->create();

        $this->assertTrue($userMailSetting->isRejection());
    }

    /** @test */
    public function it_is_not_rejection()
    {
        $userMailSetting = UserMailSetting::factory(['is_received' => true])->create();

        $this->assertFalse($userMailSetting->isRejection());
    }
}
