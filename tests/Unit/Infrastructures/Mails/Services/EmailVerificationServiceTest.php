<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Mails\Services;

use App\Infrastructures\Mails\Client\EmailVerification;
use App\Infrastructures\Mails\Services\EmailVerificationService;
use App\Infrastructures\Models\Eloquent\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

use Tests\TestCase;

final class EmailVerificationServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function emailIsSendWithEmailVerifyTokenIncludedInTheActionUrlOfTheEmail(): void
    {
        Notification::fake();
        Notification::assertNothingSent();

        $user = User::factory()->create();
        $userOther = User::factory()->create();

        $emailVerificationService = new EmailVerificationService();
        $emailVerificationService->execute($user);

        Notification::assertSentTo(
            [$user],
            EmailVerification::class,
            function ($notification) use ($user) {
                $mail = $notification->toMail($user);

                $this->assertStringContainsString(
                    $user->email_verify_token,
                    $mail->actionUrl
                );

                return true;
            }
        );

        Notification::assertNotSentTo(
            [$userOther],
            EmailVerification::class
        );
    }
}
