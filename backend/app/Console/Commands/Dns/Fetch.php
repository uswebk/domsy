<?php

declare(strict_types=1);

namespace App\Console\Commands\Dns;

use App\Models\Subdomain;
use App\Models\User;
use App\Services\Application\Commands\Dns\FetchService;
use Illuminate\Console\Command;

final class Fetch extends Command
{
    protected $signature = 'dns:fetch';

    private FetchService $fetchService;

    private const CHUNK_SIZE = 1000;

    /**
     * @param FetchService $fetchService
     */
    public function __construct(FetchService $fetchService)
    {
        parent::__construct();

        $this->fetchService = $fetchService;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        User::chunk(self::CHUNK_SIZE, function ($users) {
            foreach ($users as $user) {
                if (!$user->enableDnsAutoFetch()) {
                    continue;
                }

                Subdomain::select('subdomains.*')
                    ->with(['domain'])
                    ->join('domains', 'subdomains.domain_id', '=', 'domains.id')
                    ->where('domains.is_fetching_dns', true)
                    ->whereIn('domains.user_id', $user->getMemberIds())
                    ->chunk(self::CHUNK_SIZE, function (
                        \Illuminate\Database\Eloquent\Collection $subdomains
                    ) {
                        $this->fetchService->handle($subdomains);
                    });
            }
        });
    }
}
