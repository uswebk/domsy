<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\MenuItem;
use App\Models\Role;
use App\Models\RoleItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class RoleItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_role()
    {
        $role = Role::factory()->create();
        $roleItem = RoleItem::factory(['role_id' => $role->id])->create();

        $this->assertTrue($roleItem->role()->exists());
    }

    /** @test */
    public function it_has_menu_item()
    {
        $menuItem = MenuItem::factory()->create();
        $roleItem = RoleItem::factory(['menu_item_id' => $menuItem->id])->create();

        $this->assertTrue($roleItem->menuItem()->exists());
    }
}
