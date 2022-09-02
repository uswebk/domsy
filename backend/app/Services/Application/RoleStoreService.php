<?php

declare(strict_types=1);

namespace App\Services\Application;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class RoleStoreService
{
    private $roleRepository;

    private $roleItemRepository;

    /**
     * @param \App\Infrastructures\Repositories\Role\RoleRepositoryInterface $roleRepository
     * @param \App\Infrastructures\Repositories\Role\RoleItemRepositoryInterface $roleItemRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Role\RoleRepositoryInterface $roleRepository,
        \App\Infrastructures\Repositories\Role\RoleItemRepositoryInterface $roleItemRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->roleItemRepository = $roleItemRepository;
    }

    /**
     * @param array $attribute
     * @return void
     */
    public function handle(array $attribute): void
    {
        $user = Auth::user();

        DB::beginTransaction();
        try {
            $role = $this->roleRepository->store([
                'name' => $attribute['name'],
                'company_id' => $user->company_id,
            ]);

            foreach ($attribute['roles'] as $menu_item_id => $enabled) {
                if ($enabled) {
                    $this->roleItemRepository->store([
                        'role_id' => $role->id,
                        'menu_item_id' => $menu_item_id,
                    ]);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
