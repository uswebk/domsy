<?php

declare(strict_types=1);

namespace App\Console\Commands\Notification\Domain;

use Carbon\Carbon;

use Illuminate\Console\Command;

final class Expiration extends Command
{
    protected $signature = 'notification:domain_expiration {executeDate}';

    protected $expirationService;

    /**
     * @param \App\Services\Application\Commands\Notification\Domain\ExpirationService $expirationService
     */
    public function __construct(
        \App\Services\Application\Commands\Notification\Domain\ExpirationService $expirationService
    ) {
        parent::__construct();

        $this->expirationService = $expirationService;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $executeDate = new Carbon($this->argument('executeDate'));

        $this->expirationService->handle($executeDate);
    }
}
