<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Domain\Client;

use App\Infrastructures\Models\Client;
use App\Infrastructures\Models\User;
use App\Infrastructures\Queries\Client\EloquentClientQueryServiceInterface;
use App\Services\Domain\Client\HasService;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

final class HasServiceTest extends TestCase
{
    use RefreshDatabase;

    private const USER_ID1 = 1;

    private const CLIENT_ID1 = 1;

    private const NOT_OWNER_USER_ID2 = 2;

    /**
     * @return array
     */
    public function dataProviderOfIsOwner(): array
    {
        return [
            'users.id === clients.user_id' => [
                [
                    'id' => self::USER_ID1,
                ],
                [
                    'id' => self::CLIENT_ID1,
                    'user_id' => self::USER_ID1,
                ],
                self::CLIENT_ID1,
                self::USER_ID1,
                true,
            ],
            'users.id !== clients.user_id' => [
                [
                    'id' => self::USER_ID1,
                ],
                [
                    'id' => self::CLIENT_ID1,
                    'user_id' => self::USER_ID1,
                ],
                self::CLIENT_ID1,
                self::NOT_OWNER_USER_ID2,
                false,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfIsOwner
     *
     * @param array $parameterOfUsers
     * @param array $parameterOfClients
     * @param integer $clientId
     * @param integer $userId
     * @param boolean $resultOfAssert
     * @return void
     */
    public function caseOfIsOwner(
        array $parameterOfUsers,
        array $parameterOfClients,
        int $clientId,
        int $userId,
        bool $resultOfAssert
    ): void {
        User::factory($parameterOfUsers)->create();
        Client::factory($parameterOfClients)->create();

        $hasService = new HasService(new EloquentClientQueryServiceInterface());
        $this->assertSame($resultOfAssert, $hasService->isOwner($clientId, $userId));
    }
}
