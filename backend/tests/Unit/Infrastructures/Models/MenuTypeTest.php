<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Models;

use App\Infrastructures\Models\Menu;
use App\Infrastructures\Models\MenuItem;
use App\Infrastructures\Models\MenuType;
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
