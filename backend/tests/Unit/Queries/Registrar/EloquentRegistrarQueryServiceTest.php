<?php

declare(strict_types=1);

namespace Tests\Unit\Queries\Registrar;

use App\Models\Registrar;
use App\Models\User;
use App\Queries\Registrar\EloquentRegistrarQueryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentRegistrarQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array
     */
    public function dataProviderOfFirstByIdUserId(): array
    {
        return [
            'match id & user_id' => [
                ['id' => 1, 'user_id' => 1],
                1,
                1,
                false,
            ],
            'not match id' => [
                ['id' => 1, 'user_id' => 1],
                2,
                1,
                true,
            ],
            'not match user id' => [
                ['id' => 1, 'user_id' => 1],
                1,
                2,
                true,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfFirstByIdUserId
     */
    public function it_first_by_id_user_id(
        array $attrOfRegistrar,
        int $id,
        int $userId,
        bool $assertException
    ): void {
        User::factory()->create(['id' => $attrOfRegistrar['user_id']]);
        Registrar::factory()->create($attrOfRegistrar);

        try {
            $registrar = (new EloquentRegistrarQueryService())->firstByIdUserId($id, $userId);
            $this->assertSame($id, $registrar->id);
            $this->assertSame($userId, $registrar->user_id);
        } catch (ModelNotFoundException $e) {
            $this->assertTrue($assertException);
        }
    }
}
