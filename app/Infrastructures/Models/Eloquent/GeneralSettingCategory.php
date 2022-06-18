<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

final class GeneralSettingCategory extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'annotation',
        'sort',
    ];

    protected $casts = [
        'name' => 'string',
        'annotation' => 'string',
        'sort' => 'integer',
    ];

    public const DNS_AUTO_FETCH_NAME = 'dns_auto_fetch';

    /**
     * @param string $generalCategoryName
     * @return boolean
     */
    public function isMatchByGeneralCategoryName(string $generalCategoryName): bool
    {
        return $this->name == $generalCategoryName;
    }

    /**
     * @return boolean
     */
    public function isDnsAutoFetch(): bool
    {
        return $this->isMatchByGeneralCategoryName(self::DNS_AUTO_FETCH_NAME);
    }
}
