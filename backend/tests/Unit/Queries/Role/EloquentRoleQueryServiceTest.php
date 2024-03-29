<?php

declare(strict_types=1);

namespace Tests\Unit\Queries\Role;

use App\Models\Company;
use App\Models\Role;
use App\Queries\Role\EloquentRoleQueryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentRoleQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array
     */
    public function dataProviderOfFindById(): array
    {
        return [
            'match id' => [['id' => 1,], 1, false,],
            'not match id' => [['id' => 2,], 1, true,],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfFindById
     */
    public function it_first_by_id(array $roles, int $roleId, bool $assertException): void
    {
        Role::factory()->create($roles);

        try {
            $role = (new EloquentRoleQueryService())->findById($roleId);
            $this->assertSame($roleId, $role->id);
        } catch (ModelNotFoundException $e) {
            $this->assertTrue($assertException);
        }
    }

    /**
     * @return array
     */
    public function dataProviderOfGetByCompanyId(): array
    {
        return [
            'exists' => [1, 1, 1,],
            'not exists' => [1, 2, 0,],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetByCompanyId
     */
    public function it_get_by_company_id(int $companyId, int $roleId, int $assertCount): void
    {
        Role::factory()->create([
            'company_id' => Company::factory()->create(['id' => $companyId])->id,
        ]);

        $roles = (new EloquentRoleQueryService())->getByCompanyId($roleId);

        $this->assertSame($assertCount, $roles->count());
    }
}
