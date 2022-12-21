<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\MenuItem;
use App\Models\Role;
use App\Models\RoleItem;
use Illuminate\Database\Eloquent\Factories\Factory;

final class RoleItemFactory extends Factory
{
    protected $model = RoleItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role_id' => Role::factory(),
            'menu_item_id' => MenuItem::factory(),
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
