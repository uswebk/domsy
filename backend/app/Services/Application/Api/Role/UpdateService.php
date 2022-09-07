<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Role;

use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class UpdateService
{
    private $roleRepository;

    private $roleItemRepository;

    private $role;

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
     * @param \App\Infrastructures\Models\Role $role
     * @return void
     */
    public function handle(
        array $attribute,
        \App\Infrastructures\Models\Role $role
    ): void {
        $user = Auth::user();

        DB::beginTransaction();
        try {
            $role->fill([
                'name' => $attribute['name'],
            ]);

            $this->role = $this->roleRepository->save($role);

            $this->roleItemRepository->deleteByRoleId($role->id);
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

    /**
     * @return \App\Http\Resources\RoleResource
     */
    public function getResponse(): \App\Http\Resources\RoleResource
    {
        return new RoleResource($this->role);
    }
}
