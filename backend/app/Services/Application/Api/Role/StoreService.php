<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Role;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Repositories\Role\RoleItemRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class StoreService
{
    private RoleRepositoryInterface $roleRepository;

    private RoleItemRepositoryInterface $roleItemRepository;

    private Role $role;

    /**
     * @param RoleRepositoryInterface $roleRepository
     * @param RoleItemRepositoryInterface $roleItemRepository
     */
    public function __construct(
        RoleRepositoryInterface $roleRepository,
        RoleItemRepositoryInterface $roleItemRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->roleItemRepository = $roleItemRepository;
    }

    /**
     * @param array $attribute
     * @return void
     * @throws Exception
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
     * @return RoleResource
     */
    public function getResponse(): RoleResource
    {
        return new RoleResource($this->role);
    }
}
