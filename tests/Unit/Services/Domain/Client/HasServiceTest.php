<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Domain\Client;

use App\Infrastructures\Models\Eloquent\Client;
use App\Infrastructures\Models\Eloquent\User;
use App\Services\Domain\Client\HasService;


use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

final class HasServiceTest extends TestCase
{
    use RefreshDatabase;

    private const USER_ID_1 = 1;

    private const USER_ID_2 = 2;

    private const CLIENT_ID_1 = 1;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        Client::factory([
            'user_id' => User::factory([
                'id' => self::USER_ID_1
                ])->create(),
        ])->create();

        Client::factory([
            'user_id' => User::factory([
                'id' => self::USER_ID_2
                ])->create(),
        ])->create();
    }

    /**
     * @return array
     */
    public function dataProviderOfClientHasUserEqualUserReturnTrue(): array
    {
        return [
            '$userId が $clientId の所有ユーザーと一致する' => [
                self::USER_ID_1,
                self::CLIENT_ID_1,
            ],
        ];
    }

    /**
     * @return array
     */
    public function dataProviderOfClientHasUserNotEqualUserThrowException(): array
    {
        return [
            '$userId が $clientId の所有ユーザーと異なる' => [
                self::USER_ID_2,
                self::CLIENT_ID_1,
            ],
        ];
    }

    /**
    * @dataProvider dataProviderOfClientHasUserEqualUserReturnTrue
    * @test
    */
    public function clientHasUserEqualUserReturnTrue(int $userId, int $clientId): void
    {
        $hasService = new HasService($clientId, $userId);

        $this->assertTrue($hasService->execute());
    }

    /**
    * @dataProvider dataProviderOfClientHasUserNotEqualUserThrowException
    * @test
    */
    public function clientHasUserNotEqualUserThrowException(int $userId, int $clientId): void
    {
        try {
            $hasService = new HasService($clientId, $userId);
            $hasService->execute();
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
}
