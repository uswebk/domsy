<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\MenuItem;
use App\Models\Role;
use App\Models\RoleItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_role_items()
    {
        $role = Role::factory()->has(RoleItem::factory())->create();

        $this->assertTrue($role->roleItems()->exists());
    }

    /** @test */
    public function it_has_role_item()
    {
        $routeName = 'top.index';
        $role = Role::factory()->has(RoleItem::factory([
            'menu_item_id' => MenuItem::factory(['route' => $routeName]),
        ]))->create();

        $this->assertTrue($role->hasRoleItem($routeName));
    }

    /** @test */
    public function it_has_not_role_item()
    {
        $routeName = 'top.index';
        $role = Role::factory()->has(RoleItem::factory([
            'menu_item_id' => MenuItem::factory(['route' => $routeName]),
        ]))->create();

        $this->assertFalse($role->hasRoleItem($routeName . '_dummy'));
    }
}
