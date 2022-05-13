<?php

declare(strict_types=1);

namespace App\Services\Application\Commands\Notification\Domain;

final class ExpirationService
{
    public function __construct()
    {
    }


    public function handle(\Carbon\Carbon $target_date): void
    {
        //// ユーザー情報取得 [users]　※ユーザーのメール通知設定を見る
        //// ユーザー情報からドメイン情報取得 [user.domains]
        //// ドメインの有効期限を取得 [domain.expired_at]
        //// ドメインの有効期限が設定された通知日対象日時の場合メール送信
        //// 通知日対象日時=仮で30日前 後ほどユーザーごとに指定できるようにする
    }
}
