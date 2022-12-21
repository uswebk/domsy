<?php

declare(strict_types=1);

namespace Tests\Unit\Mails\Services;

use App\Mails\Client\EmailVerification;
use App\Mails\Services\EmailVerificationService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

final class EmailVerificationServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_email_is_send_with_email_verify_token_included_in_the_action_url_of_the_email(): void
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
