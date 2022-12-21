<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Queries\User;

use App\Models\User;
use App\Infrastructures\Queries\User\EloquentUserQueryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentUserQueryServiceTest extends TestCase
{
    use RefreshDatabase;

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
     */
    public function it_find_by_id(
        array $parameterOfUsers,
        int $userId,
        bool $isException
    ): void {
        User::factory($parameterOfUsers)->create();

        try {
            $user = (new EloquentUserQueryService())->findById($userId);

            $this->assertSame($userId, $user->id);
        } catch (ModelNotFoundException $e) {
            $this->assertTrue($isException);
        }
    }

    /**
     * @return array
     */
    public function dataProviderOfGetActiveUsers(): array
    {
        return [
            'exists active user' => [
                [
                    'id' => self::USER_ID1,
                    'deleted_at' => null,
                ],
                1,
            ],
            'not exists active user' => [
                [
                    'id' => self::USER_ID1,
                    'deleted_at' => now(),
                ],
                0,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetActiveUsers
     */
    public function it_get_active_users(
        array $parameterOfUsers,
        int $assertionCount
    ): void {
        User::factory($parameterOfUsers)->create();

        $users = (new EloquentUserQueryService())->getActiveUsers();

        $this->assertSame($users->count(), $assertionCount);
    }

    /**
     * @return array
     */
    public function dataProviderOfFirstByIdEmailVerifyToken(): array
    {
        return [
            'exists match user' => [
                [
                    'id' => self::USER_ID1,
                    'email_verify_token' => 'token',
                ],
                self::USER_ID1,
                'token',
                false,
            ],
            'not match email_verify_token' => [
                [
                    'id' => self::USER_ID1,
                    'email_verify_token' => '_token',
                ],
                self::USER_ID1,
                'token',
                true,
            ],
            'not match id' => [
                [
                    'id' => self::USER_ID1,
                    'email_verify_token' => 'token',
                ],
                self::NO_EXISTS_USER_ID1,
                'token',
                true,
            ],
            'not match id and email_verify_token' => [
                [
                    'id' => self::USER_ID1,
                    'email_verify_token' => '_token',
                ],
                self::NO_EXISTS_USER_ID1,
                'token',
                true,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfFirstByIdEmailVerifyToken
     */
    public function it_get_user_by_id_and_email_verify_token(
        array $parameterOfUsers,
        int $id,
        string $emailVerifyToken,
        bool $isException
    ): void {
        User::factory($parameterOfUsers)->create();

        try {
            $user = (new EloquentUserQueryService())->firstByIdEmailVerifyToken($id, $emailVerifyToken);

            $this->assertSame($id, $user->id);
        } catch (ModelNotFoundException $e) {
            $this->assertTrue($isException);
        }
    }
}
