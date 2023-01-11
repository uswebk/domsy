<?php

declare(strict_types=1);

namespace Tests\Unit\Queries\Menu;

use App\Models\Menu;
use App\Queries\Menu\EloquentMenuQueryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentMenuQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array
     */
    public function dataProviderOfFindById(): array
    {
        return [
            'exists id' => [1, 1, false,],
            'not exists id' => [1, 2, true,],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfFindById
     */
    public function it_find_by_id(int $menuId, int $assertMenuId, bool $assertException): void
    {
        Menu::factory(['id' => $menuId])->create();

        try {
            $menu = (new EloquentMenuQueryService())->findById($menuId);
            $this->assertSame($menu->id, $menuId);
        } catch (ModelNotFoundException $e) {
            $this->assertTrue($assertException);
        }
    }
}
