<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Role;

use App\Http\Resources\RoleResource;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class StoreService
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
     * @return void
     */
    public function handle(array $attribute): void
    {
        $user = Auth::user();

        DB::beginTransaction();
        try {
            $this->role = $this->roleRepository->store([
                'name' => $attribute['name'],
                'company_id' => $user->company_id,
            ]);

            foreach ($attribute['roles'] as $menu_item_id => $enabled) {
                if ($enabled) {
                    $this->roleItemRepository->store([
                        'role_id' => $this->role->id,
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
