<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Mails\Services;

use App\Infrastructures\Mails\Client\EmailVerification;
use App\Infrastructures\Mails\Services\EmailVerificationService;
use App\Infrastructures\Models\Eloquent\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

final class EmailVerificationServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
    * @test
    */
    public function sendVerificationEmail()
    {
        Notification::fake();
        Notification::assertNothingSent();

        $user = User::factory()->create();
        $userOther = User::factory()->create();

        $emailVerificationService = new EmailVerificationService();
        $emailVerificationService->execute($user);

        Notification::assertSentTo(
            [$user],
            EmailVerification::class
        );

        Notification::assertNotSentTo(
            [$userOther],
            EmailVerification::class
        );
    }
}
