<?php

declare(strict_types=1);

namespace App\Console\Commands\DNS;

use App\Infrastructures\Models\Eloquent\User;
use Illuminate\Console\Command;

final class Fetch extends Command
{
    protected $signature = 'dns:fetch {userId?}';

    private $fetchService;

    private $userQueryService;

    public function __construct(
        \App\Services\Application\Commands\DNS\FetchService $fetchService,
        \App\Infrastructures\Queries\User\EloquentUserQueryServiceInterface $userQueryService
    ) {
        parent::__construct();

        $this->fetchService = $fetchService;
        $this->userQueryService = $userQueryService;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $userId = $this->argument('userId');

        if (isset($userId)) {
            $user = $this->userQueryService->findById((int) $userId);

            $subdomains = $user->getSubdomains();

            $this->fetchService->handle($subdomains);
        } else {
            // TODO: 自動取得設定ユーザーのみ対象(chunk)
            // User::where()->get()->chunk(1000, function ($users) {
            //     foreach ($users as $user) {
            //         $subdomains = $user->getSubdomains();

            //         $this->fetchService->handle($subdomains);
            //     }
            // });
        }
    }
}
