<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Models;

use App\Infrastructures\Models\Menu;
use App\Infrastructures\Models\MenuItem;
use App\Infrastructures\Models\MenuType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class MenuTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function has_menu_type()
    {
        $menu = Menu::factory()->for(MenuType::factory())->create();

        $this->assertTrue($menu->menuType()->exists());
    }

    /** @test */
    public function has_many_menu_items()
    {
        $menu = Menu::factory()->has(MenuItem::factory()->count(3))->create();

        $this->assertTrue($menu->menuItems()->exists());
    }

    /** @test */
    public function is_nav()
    {
        $menu = Menu::factory([
            'is_nav' => true
        ])->create();

        $this->assertTrue($menu->isNav());
    }

    /** @test */
    public function is_not_nav()
    {
        $menu = Menu::factory([
            'is_nav' => false
        ])->create();

        $this->assertFalse($menu->isNav());
    }
}
