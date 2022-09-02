<?php

declare(strict_types=1);

namespace App\Console\Commands\DNS;

use App\Infrastructures\Models\User;

use Illuminate\Console\Command;

final class Fetch extends Command
{
    protected $signature = 'dns:fetch {userId?}';

    private $fetchService;

    private $userQueryService;

    private const CHUNK_SIZE = 1000;

    /**
     * @param \App\Services\Application\Commands\DNS\FetchService $fetchService
     * @param \App\Infrastructures\Queries\User\EloquentUserQueryServiceInterface $userQueryService
     */
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
            User::chunk(self::CHUNK_SIZE, function ($users) {
                foreach ($users as $user) {
                    if (! $user->enableDnsAutoFetch()) {
                        continue;
                    }

                    $subdomains = $user->getSubdomains();

                    $this->fetchService->handle($subdomains);
                }
            });
        }
    }
}
