<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Constants\CompanyConstant;
use App\Constants\MailCategoryConstant;
use App\Constants\RoleConstant;
use App\Models\Client;
use App\Models\Company;
use App\Models\Domain;
use App\Models\GeneralSettingCategory;
use App\Models\MailCategory;
use App\Models\MenuItem;
use App\Models\Registrar;
use App\Models\Role;
use App\Models\RoleItem;
use App\Models\SocialAccount;
use App\Models\User;
use App\Models\UserGeneralSetting;
use App\Models\UserMailSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed('CompanySeeder');
        $this->seed('RoleSeeder');
    }

    /** @test */
    public function it_has_company(): void
    {
        $user = User::factory()->create();

        $this->assertTrue($user->company()->exists());
    }

    /** @test */
    public function it_has_role(): void
    {
        $user = User::factory()->create();

        $this->assertTrue($user->role()->exists());
    }

    /** @test */
    public function it_has_social_accounts(): void
    {
        $user = User::factory()->has(SocialAccount::factory()->count(3))->create();

        $this->assertTrue($user->socialAccounts()->exists());
    }

    /** @test */
    public function it_has_domains(): void
    {
        $user = User::factory()->has(Domain::factory()->count(3))->create();

        $this->assertTrue($user->domains()->exists());
    }

    /** @test */
    public function it_has_registrars(): void
    {
        $user = User::factory()->has(Registrar::factory()->count(3))->create();

        $this->assertTrue($user->registrars()->exists());
    }

    /** @test */
    public function it_has_clients(): void
    {
        $user = User::factory()->has(Client::factory()->count(3))->create();

        $this->assertTrue($user->clients()->exists());
    }

    /** @test */
    public function it_has_mail_settings(): void
    {
        $user = User::factory()->create();
        UserMailSetting::factory(['user_id' => $user->id])->create();

        $this->assertTrue($user->mailSettings()->exists());
    }

    /** @test */
    public function it_has_general_setting(): void
    {
        $user = User::factory()->create();
        UserGeneralSetting::factory(['user_id' => $user->id])->create();

        $this->assertTrue($user->generalSettings()->exists());
    }

    /** @test */
    public function it_is_company(): void
    {
        $company = Company::factory(['id' => 2])->create();
        $user = User::factory(['company_id' => $company->id])->create();

        $this->assertTrue($user->isCompany());
    }

    /** @test */
    public function it_is_individual(): void
    {
        $user = User::factory(['company_id' => CompanyConstant::INDEPENDENT_COMPANY_ID])->create();

        $this->assertFalse($user->isCompany());
    }

    /** @test */
    public function it_has_role_item_then_administrator(): void
    {
        $user = User::factory(['role_id' => RoleConstant::DEFAULT_ROLE_ID])->create();

        $this->assertTrue($user->hasRoleItem(''));
    }

    /** @test */
    public function it_has_role_item_then_excepting_administrator(): void
    {
        $routeName = 'top.index';
        $role = Role::factory()->has(RoleItem::factory([
            'menu_item_id' => MenuItem::factory(['route' => $routeName]),
        ]))->create();

        $user = User::factory(['role_id' => $role->id])->create();

        $this->assertTrue($user->hasRoleItem($routeName));
    }

    /** @test */
    public function it_has_not_role_item_then_excepting_administrator(): void
    {
        $routeName = 'top.index';
        $role = Role::factory()->has(RoleItem::factory([
            'menu_item_id' => MenuItem::factory(['route' => $routeName]),
        ]))->create();

        $user = User::factory(['role_id' => $role->id])->create();

        $this->assertFalse($user->hasRoleItem($routeName . '_'));
    }

    /** @test */
    public function it_get_receive_domain_expiration_mail_setting(): void
    {
        $user = User::factory()->create();
        UserMailSetting::factory([
            'user_id' => $user->id,
        ])->for(MailCategory::factory([
            'name' => MailCategoryConstant::DOMAIN_EXPIRATION_NAME,
        ]))->create();

        $mailSetting = $user->getReceiveDomainExpirationMailSetting();

        $this->assertInstanceOf('\App\Models\UserMailSetting', $mailSetting);
    }

    /** @test */
    public function it_get_receive_domain_expiration_mail_setting_then_null(): void
    {
        $user = User::factory()->create();
        UserMailSetting::factory([
            'user_id' => $user->id,
        ])->for(MailCategory::factory([
            'name' => 'hoge',
        ]))->create();

        $mailSetting = $user->getReceiveDomainExpirationMailSetting();

        $this->assertNull($mailSetting);
    }

    /** @test */
    public function it_is_received_mail_by_mail_category_id(): void
    {
        $mailCategoryId = 1;

        $user = User::factory()->create();
        UserMailSetting::factory([
            'user_id' => $user->id,
            'is_received' => true,
        ])->for(MailCategory::factory([
            'id' => $mailCategoryId,
            'name' => MailCategoryConstant::DOMAIN_EXPIRATION_NAME,
        ]))->create();

        $this->assertTrue($user->isReceivedMailByMailCategoryId($mailCategoryId));
    }

    /** @test */
    public function it_is_not_received_mail_by_mail_category_id(): void
    {
        $mailCategoryId = 1;

        $user = User::factory()->create();
        UserMailSetting::factory([
            'user_id' => $user->id,
            'is_received' => false,
        ])->for(MailCategory::factory([
            'id' => $mailCategoryId,
            'name' => MailCategoryConstant::DOMAIN_EXPIRATION_NAME,
        ]))->create();

        $this->assertFalse($user->isReceivedMailByMailCategoryId($mailCategoryId));
    }

    /** @test */
    public function it_is_not_received_mail_by_mail_category_id_then_no_setting(): void
    {
        $mailCategoryId = 1;

        $user = User::factory()->create();
        UserMailSetting::factory([
            'user_id' => $user->id,
            'is_received' => true,
        ])->for(MailCategory::factory([
            'id' => $mailCategoryId,
            'name' => MailCategoryConstant::DOMAIN_EXPIRATION_NAME,
        ]))->create();

        $this->assertFalse($user->isReceivedMailByMailCategoryId(2));
    }

    /** @test */
    public function it_get_mail_setting_notice_number_days_by_mail_category_id(): void
    {
        $mailCategoryId = 1;
        $days = 10;

        $user = User::factory()->create();
        UserMailSetting::factory([
            'user_id' => $user->id,
            'is_received' => true,
            'notice_number_days' => $days,
        ])->for(MailCategory::factory([
            'id' => $mailCategoryId,
            'name' => MailCategoryConstant::DOMAIN_EXPIRATION_NAME,
        ]))->create();

        $this->assertSame($days, $user->getMailSettingNoticeNumberDaysByMailCategoryId($mailCategoryId));
    }

    /** @test */
    public function it_get_mail_setting_notice_number_days_by_mail_category_id_then_default(): void
    {
        $mailCategoryId_1 = 1;
        $mailCategoryId_2 = 2;
        $days = 10;
        $defaultDays = 15;

        $user = User::factory()->create();
        UserMailSetting::factory([
            'user_id' => $user->id,
            'is_received' => true,
            'notice_number_days' => $days,
        ])->for(MailCategory::factory([
            'id' => $mailCategoryId_1,
            'name' => MailCategoryConstant::DOMAIN_EXPIRATION_NAME,
        ]))->create();

        MailCategory::factory([
            'id' => $mailCategoryId_2,
            'default_days' => $defaultDays,
        ])->create();

        $this->assertSame($defaultDays, $user->getMailSettingNoticeNumberDaysByMailCategoryId($mailCategoryId_2));
    }

    /** @test */
    public function it_enable_general_setting_by_general_id(): void
    {
        $generalCategoryId = 1;

        $user = User::factory()->create();
        UserGeneralSetting::factory([
            'user_id' => $user->id,
            'enabled' => true,
        ])->for(GeneralSettingCategory::factory([
            'id' => $generalCategoryId,
        ]))->create();

        $this->assertTrue($user->enableGeneralSettingByGeneralId($generalCategoryId));
    }

    /** @test */
    public function it_no_enable_general_setting_by_general_id(): void
    {
        $generalCategoryId = 1;

        $user = User::factory()->create();
        UserGeneralSetting::factory([
            'user_id' => $user->id,
            'enabled' => false,
        ])->for(GeneralSettingCategory::factory([
            'id' => $generalCategoryId,
        ]))->create();

        $this->assertFalse($user->enableGeneralSettingByGeneralId($generalCategoryId));
    }

    /** @test */
    public function it_enable_general_setting_by_general_id_then_no_setting(): void
    {
        $generalCategoryId = 1;

        $user = User::factory()->create();
        UserGeneralSetting::factory([
            'user_id' => $user->id,
            'enabled' => false,
        ])->for(GeneralSettingCategory::factory([
            'id' => $generalCategoryId,
        ]))->create();

        $this->assertFalse($user->enableGeneralSettingByGeneralId(2));
    }

    /** @test */
    public function it_enable_dns_auto_fetch(): void
    {
        $name = 'dns_auto_fetch';

        $user = User::factory()->create();
        UserGeneralSetting::factory([
            'user_id' => $user->id,
            'enabled' => true,
        ])->for(GeneralSettingCategory::factory([
            'name' => $name,
        ]))->create();

        $this->assertTrue($user->enableDnsAutoFetch());
    }

    /** @test */
    public function it_not_enable_dns_auto_fetch(): void
    {
        $name = 'dns_auto_fetch';

        $user = User::factory()->create();
        UserGeneralSetting::factory([
            'user_id' => $user->id,
            'enabled' => false,
        ])->for(GeneralSettingCategory::factory([
            'name' => $name,
        ]))->create();

        $this->assertFalse($user->enableDnsAutoFetch());
    }

    /** @test */
    public function it_not_enable_dns_auto_fetch_then_no_setting(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->enableDnsAutoFetch());
    }

    /** @test */
    public function it_get_members_then_company(): void
    {
        $count = 3;
        $assertCount = $count + 1;

        $company = Company::factory(['id' => 2])->create();
        $user = User::factory(['company_id' => $company->id])->create();
        User::factory(['company_id' => $company->id])->count($count)->create();

        $this->assertCount($assertCount, $user->getMembers());
    }

    /** @test */
    public function it_get_members_then_individual(): void
    {
        $assertCount = 1;

        $user = User::factory(['company_id' => CompanyConstant::INDEPENDENT_COMPANY_ID])->create();

        $this->assertCount($assertCount, $user->getMembers());
    }

    /** @test */
    public function it_get_member_ids_then_company(): void
    {
        $count = 3;
        $assertCount = $count + 1;

        $company = Company::factory(['id' => 2])->create();
        $user = User::factory(['company_id' => $company->id])->create();
        User::factory(['company_id' => $company->id])->count($count)->create();

        $this->assertCount($assertCount, $user->getMemberIds());
    }

    /** @test */
    public function it_get_member_ids_then_individual(): void
    {
        $user = User::factory(['company_id' => CompanyConstant::INDEPENDENT_COMPANY_ID])->create();

        $this->assertCount(1, $user->getMemberIds());
    }

    /** @test */
    public function it_is_social(): void
    {
        $user = User::factory()->has(SocialAccount::factory()->count(3))->create();

        $this->assertTrue($user->isSocial());
    }

    /** @test */
    public function it_is_not_social(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->isSocial());
    }

    /** @test */
    public function it_get_social_avatar(): void
    {
        $avatarPath = 'img.domsy/1111/1111.png';
        $user = User::factory()->has(SocialAccount::factory(['avatar_path' => $avatarPath]))->create();

        $this->assertSame($avatarPath, $user->getSocialAvatar());
    }

    /** @test */
    public function it_get_social_avatar_then_no_social(): void
    {
        $avatarPath = '';
        $user = User::factory()->create();

        $this->assertSame($avatarPath, $user->getSocialAvatar());
    }
}
