<?php

declare(strict_types=1);

namespace App\Console\Commands\DNS;

use App\Infrastructures\Models\Eloquent\User;
use Illuminate\Console\Command;

final class Fetch extends Command
{
    protected $signature = 'dns:fetch {userId?}';

    private $fetchService;

    public function __construct(
        \App\Services\Application\Commands\DNS\FetchService $fetchService
    ) {
        parent::__construct();

        $this->fetchService = $fetchService;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $userId = $this->argument('userId');

        if (isset($userId)) {
            $user = User::findOrFail($userId);

            $subdomains = $user->getSubdomains();

            $this->fetchService->handle($subdomains);
        } else {
            // 自動取得設定ユーザーのみ対象(chunk)
            // User::where()->get()->chunk(1000, function ($users) {
            //     foreach ($users as $user) {
            //         $subdomains = $user->getSubdomains();

            //         $this->fetchService->handle($subdomains);
            //     }
            // });
        }
    }
}
