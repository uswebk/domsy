<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Models;

use App\Infrastructures\Models\Menu;
use App\Infrastructures\Models\MenuItem;
use App\Infrastructures\Models\MenuType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class MenuItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_menu()
    {
        $menu = Menu::factory()->create();
        $menuItem = MenuItem::factory([
            'parent_id' => $menu->id
        ])->create();

        $this->assertTrue($menuItem->menu()->exists());
    }

    /** @test */
    public function it_is_screen()
    {
        $menuItem = MenuItem::factory([
            'is_screen' => true
        ])->create();

        $this->assertTrue($menuItem->isScreen());
    }

    /** @test */
    public function it_is_not_screen()
    {
        $menuItem = MenuItem::factory([
            'is_screen' => false
        ])->create();

        $this->assertFalse($menuItem->isScreen());
    }
}
