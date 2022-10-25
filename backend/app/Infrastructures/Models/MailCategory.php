<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

use App\Constants\MailCategoryConstant;

final class MailCategory extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'annotation',
        'is_specify_number_days',
        'default_days',
        'sort',
    ];

    protected $casts = [
        'name' => 'string',
        'annotation' => 'string',
        'is_specify_number_days' => 'boolean',
        'default_days' => 'integer',
        'sort' => 'integer',
    ];

    protected const DOMAIN_EXPIRATION_NAME = 'domain_expiration';

    /**
     * @param string $mailCategoryName
     * @return boolean
     */
    public function isMatchByMailCategoryName(string $mailCategoryName): bool
    {
        return $this->name == $mailCategoryName;
    }

    /**
     * @return boolean
     */
    public function isDomainExpiration(): bool
    {
        return $this->isMatchByMailCategoryName(MailCategoryConstant::DOMAIN_EXPIRATION_NAME);
    }

    /**
     *
     * @return boolean
     */
    public function hasDays(): bool
    {
        return $this->is_specify_number_days;
    }
}
