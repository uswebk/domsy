<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MailCategory extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'annotation',
        'sort',
    ];

    protected const DOMAIN_EXPIRATION_NAME = 'domain_expiration';

    public function isMatchByMailCategoryName($mailCategoryName): bool
    {
        return $this->name == $mailCategoryName;
    }

    public function isDomainExpiration(): bool
    {
        return $this->isMatchByMailCategoryName(self::DOMAIN_EXPIRATION_NAME);
    }
}
