<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\GeneralSettingCategory;
use App\Models\UserGeneralSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class UserGeneralSettingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_general_setting_category()
    {
        $userGeneralSetting = UserGeneralSetting::factory()->for(GeneralSettingCategory::factory())->create();

        $this->assertTrue($userGeneralSetting->generalSettingCategory()->exists());
    }

    /** @test */
    public function it_is_dns_auto_fetch()
    {
        $name = 'dns_auto_fetch';
        $userGeneralSetting = UserGeneralSetting::factory()->for(GeneralSettingCategory::factory([
            'name' => $name,
        ]))->create();

        $this->assertTrue($userGeneralSetting->isDnsAutoFetch());
    }

    /** @test */
    public function it_is_not_dns_auto_fetch()
    {
        $name = 'dns_auto_fetch_dummy';
        $userGeneralSetting = UserGeneralSetting::factory()->for(GeneralSettingCategory::factory([
            'name' => $name,
        ]))->create();

        $this->assertFalse($userGeneralSetting->isDnsAutoFetch());
    }
}
