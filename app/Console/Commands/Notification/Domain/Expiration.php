<?php

declare(strict_types=1);

namespace App\Console\Commands\Notification\Domain;

use Illuminate\Console\Command;

class Expiration extends Command
{
    protected $signature = 'notification:domain_expiration {target_date?}';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {

      // target_date処理

      // ApplicationService(Carbon target_date)

      //// ユーザー情報取得 [users]　※ユーザーのメール通知設定を見る
      //// ユーザー情報からドメイン情報取得 [user.domains]
      //// ドメインの有効期限を取得 [domain.expired_at]
      //// ドメインの有効期限が設定された通知日対象日時の場合メール送信
      //// 通知日対象日時=仮で30日前 後ほどユーザーごとに指定できるようにする
    }
}
