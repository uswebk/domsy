<?php

declare(strict_types=1);

namespace Tests\Unit\Queries\Menu;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Queries\Menu\EloquentMenuItemQueryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentMenuItemQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array
     */
    public function dataProviderOfGetByEndpoint(): array
    {
        return [
            'exists endpoint' => ['endpoint', 'endpoint', false,],
            'not exists endpoint' => ['endpoint', 'endpoint_dummy', true,],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetByEndpoint
     */
    public function it_get_by_endpoint(string $endpoint, string $searchEndpoint, bool $assertException): void
    {
        MenuItem::factory(['endpoint' => $endpoint])->create();
        try {
            $menu_item = (new EloquentMenuItemQueryService())->getByEndpoint($searchEndpoint);
            $this->assertSame($menu_item->endpoint, $endpoint);
        } catch (ModelNotFoundException $e) {
            $this->assertTrue($assertException);
        }
    }

    /**
     * @return array
     */
    public function dataProviderOfGetNavigationItems(): array
    {
        return [
            'exists navigation' => [
                [
                    [
                        'id' => 1,
                        'is_nav' => true,
                    ],
                ],
                [
                    [
                        'parent_id' => 1,
                        'is_screen' => true,
                    ],
                ],
                1,
            ],
            'exists navigation, has is not nav' => [
                [
                    [
                        'id' => 1,
                        'is_nav' => false,
                    ],
                ],
                [
                    [
                        'parent_id' => 1,
                        'is_screen' => true,
                    ],
                ],
                0,
            ],
            'exists navigation, has is not screen' => [
                [
                    [
                        'id' => 1,
                        'is_nav' => true,
                    ],
                ],
                [
                    [
                        'parent_id' => 1,
                        'is_screen' => false,
                    ],
                ],
                0,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetNavigationItems
     */
    public function it_get_navigation_items(
        array $parameterOfMenus,
        array $parameterOfMenuItems,
        int $assertCount
    ): void {
        foreach ($parameterOfMenus as $menu) {
            Menu::factory($menu)->create();
        }
        foreach ($parameterOfMenuItems as $menuItem) {
            MenuItem::factory($menuItem)->create();
        }
        $menu_items = (new EloquentMenuItemQueryService())->getNavigationItems();
        $this->assertSame($menu_items->count(), $assertCount);
    }
}
