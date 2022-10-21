<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Models;

use App\Infrastructures\Models\GeneralSettingCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GeneralSettingCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_is_match_by_general_category_name(): void
    {
        $name = 'dns_auto_fetch';
        $generalSettingCategory = GeneralSettingCategory::factory([
            'name' => $name,
        ])->create();

        $this->assertTrue($generalSettingCategory->isMatchByGeneralCategoryName($name));
    }

    /** @test */
    public function it_is_not_match_by_general_category_name(): void
    {
        $name = 'dns_auto_fetch';
        $generalSettingCategory = GeneralSettingCategory::factory([
            'name' => $name,
        ])->create();

        $this->assertFalse($generalSettingCategory->isMatchByGeneralCategoryName($name . '_dummy'));
    }

    /** @test */
    public function it_is_dns_auto_fetch(): void
    {
        $name = 'dns_auto_fetch';
        $generalSettingCategory = GeneralSettingCategory::factory([
            'name' => $name,
        ])->create();

        $this->assertTrue($generalSettingCategory->isDnsAutoFetch());
    }

    /** @test */
    public function it_is_not_dns_auto_fetch(): void
    {
        $name = 'dns_auto_fetch_dummy';
        $generalSettingCategory = GeneralSettingCategory::factory([
            'name' => $name,
        ])->create();

        $this->assertFalse($generalSettingCategory->isDnsAutoFetch());
    }
}
