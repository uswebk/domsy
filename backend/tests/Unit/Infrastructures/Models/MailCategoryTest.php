<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Models;

use App\Constants\MailCategoryConstant;
use App\Infrastructures\Models\MailCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class MailCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_is_match_by_mail_category_name()
    {
        $name = 'Test';
        $mailCategory = MailCategory::factory(['name' => $name])->create();

        $this->assertTrue($mailCategory->isMatchByMailCategoryName($name));
    }

    /** @test */
    public function it_is_not_match_by_mail_category_name()
    {
        $name = 'Test';
        $mailCategory = MailCategory::factory(['name' => $name])->create();

        $this->assertFalse($mailCategory->isMatchByMailCategoryName($name . '_dummy'));
    }

    /** @test */
    public function it_is_domain_expiration()
    {
        $mailCategory = MailCategory::factory(['name' => MailCategoryConstant::DOMAIN_EXPIRATION_NAME])->create();

        $this->assertTrue($mailCategory->isDomainExpiration());
    }

    /** @test */
    public function it_is_not_domain_expiration()
    {
        $mailCategory = MailCategory::factory(['name' => 'domain_expiration_dummy'])->create();

        $this->assertFalse($mailCategory->isDomainExpiration());
    }

    /** @test */
    public function it_has_days()
    {
        $mailCategory = MailCategory::factory(['is_specify_number_days' => true])->create();

        $this->assertTrue($mailCategory->hasDays());
    }

    /** @test */
    public function it_do_not_has_days()
    {
        $mailCategory = MailCategory::factory(['is_specify_number_days' => false])->create();

        $this->assertFalse($mailCategory->hasDays());
    }
}
