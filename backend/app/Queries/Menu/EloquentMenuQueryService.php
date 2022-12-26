<?php

declare(strict_types=1);

namespace App\Queries\Menu;

use App\Models\Menu;

final class EloquentMenuQueryService implements EloquentMenuQueryServiceInterface
{
    /**
     * @param integer $id
     * @return Menu
     */
    public function findById(int $id): Menu
    {
        return Menu::findOrFail($id);
    }
}
