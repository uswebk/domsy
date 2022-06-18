<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

final class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'code',
        'name',
        'email',
        'password',
        'email_verify_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'email_verified_at',
        'deleted_at',
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domains(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Eloquent\Domain');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registrars(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Eloquent\Registrar');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Eloquent\Client');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mailSettings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Eloquent\UserMailSetting');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function generalSettings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Infrastructures\Models\Eloquent\UserGeneralSetting');
    }

    /**
     * @return \App\Infrastructures\Models\Eloquent\UserMailSetting|null
     */
    public function getReceiveDomainExpirationMailSetting(): ?\App\Infrastructures\Models\Eloquent\UserMailSetting
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
}
