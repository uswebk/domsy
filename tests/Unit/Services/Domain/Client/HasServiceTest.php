<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Domain\Client;

use App\Infrastructures\Models\Eloquent\Client;
use App\Infrastructures\Models\Eloquent\User;
use App\Services\Domain\Client\HasService;

use Exception;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

final class HasServiceTest extends TestCase
{
    use RefreshDatabase;

    private const USER_ID_1 = 1;

    private const USER_ID_2 = 2;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @return array
     */
    public function hasClientCheckDataProvider(): array
    {
        return [
            'UserとClientが一致する' => [
                self::USER_ID_1,
                self::USER_ID_1,
                true,
            ],
            'UserとClientが一致しない' => [
                self::USER_ID_2,
                self::USER_ID_1,
                false,
            ],
        ];
    }

    /**
    * @dataProvider hasClientCheckDataProvider
    * @test
    */
    public function hasClientCheckOfDataProvider(
        int $userId,
        int $targetUserId,
        bool $assertResult
    ): void {
        try {
            $client = Client::factory([
                'user_id' => User::factory([
                    'id' => $userId
                ])->create(),
            ])->create();

            $hasService = new HasService($client->id, $targetUserId);
            $result = $hasService->execute();

            $this->assertEquals($result, $assertResult);
        } catch (Exception $e) {
            $this->assertInstanceOf(Exception::class, $e);
        }
    }
}
