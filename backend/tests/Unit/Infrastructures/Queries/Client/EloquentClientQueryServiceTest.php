<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Queries\Client;

use App\Infrastructures\Models\Client;
use App\Infrastructures\Models\User;
use App\Infrastructures\Queries\Client\EloquentClientQueryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

final class EloquentClientQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    private $userQueryService;

    private const CLIENT_ID1 = 1;

    private const CLIENT_ID2 = 2;

    /**
     * @return array
     */
    public function dataProviderOfFindById(): array
    {
        return [
            'exists client' => [
                [
                    'id' => self::CLIENT_ID1,
                ],
                self::CLIENT_ID1,
                false,
            ],
            'not exists client' => [
                [
                    'id' => self::CLIENT_ID1,
                ],
                self::CLIENT_ID2,
                true,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfFindById
     *
     * @param array $parameterOfClients
     * @param integer $id
     * @param boolean $isException
     * @return void
     */
    public function it_find_by_id(
        array $parameterOfClients,
        int $id,
        bool $isException
    ): void {
        Client::factory($parameterOfClients)->create();

        try {
            $client = (new EloquentClientQueryService())->findById($id);

            $this->assertSame($id, $client->id);
        } catch (ModelNotFoundException $e) {
            $this->assertTrue($isException);
        }
    }

    /**
     * @return array
     */
    public function dataProviderOfFirstByIdUserId(): array
    {
        return [
            'match client' => [
                [
                    'id' => 1,
                ],
                [
                    'id' => self::CLIENT_ID1,
                    'user_id' => 1,
                ],
                self::CLIENT_ID1,
                1,
                false,
            ],
            'not match client' => [
                [
                    'id' => 1,
                ],
                [
                    'id' => self::CLIENT_ID1,
                    'user_id' => 1,
                ],
                self::CLIENT_ID1,
                2,
                true,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfFirstByIdUserId
     *
     * @param array $parameterOfUsers
     * @param array $parameterOfClients
     * @param integer $id
     * @param integer $userId
     * @param boolean $isException
     * @return void
     */
    public function it_first_by_id_and_user_id(
        array $parameterOfUsers,
        array $parameterOfClients,
        int $id,
        int $userId,
        bool $isException
    ): void {
        User::factory($parameterOfUsers)->create();
        Client::factory($parameterOfClients)->create();

        try {
            $client = (new EloquentClientQueryService())->firstByIdUserId($id, $userId);

            $this->assertSame($id, $client->id);
        } catch (ModelNotFoundException $e) {
            $this->assertTrue($isException);
        }
    }

    /**
     * @return array
     */
    public function dataProviderOfGetByUserIds(): array
    {
        return [
            'match clients' => [
                [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
                [
                    [
                        'id' => self::CLIENT_ID1,
                        'user_id' => 1,
                    ],
                    [
                        'id' => self::CLIENT_ID2,
                        'user_id' => 2,
                    ],
                ],
                [1, 2,],
                2
            ],
            'not match clients' => [
                [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 2,
                    ],
                ],
                [
                    [
                        'id' => self::CLIENT_ID1,
                        'user_id' => 1,
                    ],
                    [
                        'id' => self::CLIENT_ID2,
                        'user_id' => 2,
                    ],
                ],
                [3, 4,],
                0
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderOfGetByUserIds
     *
     * @param array $parameterOfUsers
     * @param array $parameterOfClients
     * @param array $userIds
     * @param integer $count
     * @return void
     */
    public function it_get_by_user_ids(
        array $parameterOfUsers,
        array $parameterOfClients,
        array $userIds,
        int $count
    ): void {
        foreach ($parameterOfUsers as $parameterOfUser) {
            User::factory($parameterOfUser)->create();
        }

        foreach ($parameterOfClients as $parameterOfClient) {
            Client::factory($parameterOfClient)->create();
        }

        $clients = (new EloquentClientQueryService())->getByUserIds($userIds);

        $this->assertCount($count, $clients);
    }
}
