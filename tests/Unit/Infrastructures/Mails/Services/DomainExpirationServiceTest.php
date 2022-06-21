<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Mails\Services;

use App\Infrastructures\Mails\Client\DomainExpiration;

use App\Infrastructures\Mails\Services\DomainExpirationService;
use App\Infrastructures\Models\Domain;
use App\Infrastructures\Models\User;
use App\Infrastructures\Models\UserMailSetting;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

use Tests\TestCase;

final class DomainExpirationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected const MAIL_CATEGORY_ID = 1;

    protected const NOTICE_NUMBER_DAYS = 30;

    protected const DOMAIN_NAME_1 = 'test.com';

    public function setUp(): void
    {
        parent::setUp();

        $this->seed('MailCategorySeeder');
    }

    /**
    * @test
    */
    public function domainNameAndNotificationNumberDaysIncludedInTheBodyOfEmailAndSend(): void
    {
        $user = User::factory()->create();
        $userOther = User::factory()->create();

        $userMailSetting = UserMailSetting::factory()->create([
            'user_id' => $user->id,
            'mail_category_id' => self::MAIL_CATEGORY_ID,
            'notice_number_days' => self::NOTICE_NUMBER_DAYS,
        ]);

        $domains = new Collection();
        $domain = Domain::factory()->create([
            'user_id' => $user->id,
            'name' => self::DOMAIN_NAME_1,
        ]);
        $domains->push($domain);

        Notification::fake();
        Notification::assertNothingSent();

        $domainExpirationService = new DomainExpirationService();
        $domainExpirationService->execute(
            $user,
            $domains,
            $userMailSetting->notice_number_days
        );

        Notification::assertSentTo(
            [$user],
            DomainExpiration::class,
            function ($notification) use ($user) {
                $mail = $notification->toMail($user);

                foreach ($mail->viewData['domains'] as $domain) {
                    $this->assertEquals(self::DOMAIN_NAME_1, $domain->name);
                }

                $this->assertEquals(self::NOTICE_NUMBER_DAYS, $mail->viewData['domainNoticeNumberDays']);

                return true;
            }
        );

        Notification::assertNotSentTo(
            [$userOther],
            EmailVerification::class
        );
    }
}
