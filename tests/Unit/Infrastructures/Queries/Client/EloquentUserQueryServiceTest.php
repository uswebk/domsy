<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Queries\Client;

use App\Infrastructures\Models\Eloquent\User;
use App\Infrastructures\Queries\User\EloquentUserQueryService;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

final class EloquentUserQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    private $userQueryService;

    private const USER_ID1 = 1;

    private const NO_EXISTS_USER_ID1 = 2;

    /**
     * @return array
     */
    public function dataProviderOfFindById(): array
    {
        return [
            'exists user' => [
                [
                    'id' => self::USER_ID1,
                ],
                self::USER_ID1,
                false,
            ],
            'not exists user' => [
                [
                    'id' => self::USER_ID1,
                ],
                self::NO_EXISTS_USER_ID1,
                true,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfFindById
     *
     * @param array $parameterOfUsers
     * @param integer $userId
     * @param boolean $isException
     * @return void
     */
    public function caseOfFindById(
        array $parameterOfUsers,
        int $userId,
        bool $isException
    ): void {
        User::factory($parameterOfUsers)->create();

        $userQueryService = new EloquentUserQueryService();

        try {
            $user = $userQueryService->findById($userId);

            $this->assertSame($userId, $user->id);
        } catch (ModelNotFoundException $e) {
            $this->assertTrue($isException);
        }
    }
}
