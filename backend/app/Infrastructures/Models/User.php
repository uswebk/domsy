<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

use App\Constants\CompanyConstant;
use App\Constants\RoleConstant;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

final class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'code',
        'company_id',
        'role_id',
        'name',
        'email',
        'password',
        'email_verify_token',
        'last_login_at',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'email_verified_at',
        'last_login_at',
        'deleted_at',
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Company', 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Role', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domains(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Domain');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registrars(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Registrar');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Client');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mailSettings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\UserMailSetting');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function generalSettings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\UserGeneralSetting');
    }

    /**
     * @return boolean
     */
    public function isCompany(): bool
    {
        return $this->company_id !== CompanyConstant::INDEPENDENT_COMPANY_ID;
    }

    /**
     * @param string $routeName
     * @return boolean
     */
    public function hasRoleItem(string $routeName): bool
    {
        if ($this->role_id === RoleConstant::DEFAULT_ROLE_ID) {
            return true;
        }

        return $this->role->hasRoleItem($routeName);
    }

    /**
     * @return \App\Infrastructures\Models\UserMailSetting|null
     */
    public function getReceiveDomainExpirationMailSetting(): ?\App\Infrastructures\Models\UserMailSetting
    {
        foreach ($this->mailSettings as $mailSetting) {
            if ($mailSetting->isDomainExpiration()) {
                return $mailSetting;
            }
        }

        return null;
    }

    /**
     * @param integer $mailCategoryId
     * @return boolean
     */
    public function isReceivedMailByMailCategoryId(int $mailCategoryId): bool
    {
        foreach ($this->mailSettings as $mailSetting) {
            if ($mailSetting->mail_category_id !== $mailCategoryId) {
                continue;
            }

            if ($mailSetting->is_received) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param integer $mailCategoryId
     * @return integer
     */
    public function getMailSettingNoticeNumberDaysByMailCategoryId(int $mailCategoryId): int
    {
        $mailSetting = $this->mailSettings->where('mail_category_id', '=', $mailCategoryId)
            ->first();

        if (isset($mailSetting)) {
            return $mailSetting->notice_number_days;
        }

        $mailCategory = MailCategory::find($mailCategoryId);

        return $mailCategory->default_days;
    }

    /**
     * @param integer $generalId
     * @return boolean
     */
    public function enableGeneralSettingByGeneralId(int $generalId): bool
    {
        foreach ($this->generalSettings as $generalSetting) {
            if ($generalSetting->general_id !== $generalId) {
                continue;
            }

            if ($generalSetting->enabled) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return boolean
     */
    public function enableDnsAutoFetch(): bool
    {
        foreach ($this->generalSettings as $generalSetting) {
            if ($generalSetting->isDnsAutoFetch()) {
                return $generalSetting->enabled;
            }
        }

        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSubdomains(): \Illuminate\Database\Eloquent\Collection
    {
        $subdomains = new Collection();

        foreach ($this->domains as $domain) {
            $subdomains->push($domain->subdomains);
        }

        return $subdomains;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMembers(): \Illuminate\Database\Eloquent\Collection
    {
        if ($this->isCompany()) {
            return $this->company->users;
        }

        return (new Collection())->push($this);
    }

    /**
     * @return array
     */
    public function getMemberIds(): array
    {
        $users = $this->getMembers();

        return $users->pluck('id')->toArray();
    }
}
