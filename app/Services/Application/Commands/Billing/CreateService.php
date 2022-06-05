<?php

declare(strict_types=1);

namespace App\Services\Application\Commands\Billing;

final class CreateService
{
    public function __construct(
    ) {
    }

    public function handle(\Carbon\Carbon $executeDate): void
    {

        // domain_billings.billing_date が前日

        // domain_billings 作成 + interval year

        // is_fixed

        // is_fixed 変更不可

        // 変更後 changed_at 入れる
        //
    }
}
