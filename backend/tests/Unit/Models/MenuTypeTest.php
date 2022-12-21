<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Menu;
use App\Models\MenuType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class MenuTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_menu()
    {
        $menuType = MenuType::factory()->has(Menu::factory())->create();

        $this->assertTrue($menuType->menu()->exists());
    }
}
