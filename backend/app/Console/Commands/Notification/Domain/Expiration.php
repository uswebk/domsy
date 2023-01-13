<?php

declare(strict_types=1);

namespace App\Console\Commands\Notification\Domain;

use App\Services\Application\Commands\Notification\Domain\ExpirationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

final class Expiration extends Command
{
    protected $signature = 'notification:domain_expiration {executeDate}';

    protected ExpirationService $expirationService;

    /**
     * @param ExpirationService $expirationService
     */
    public function __construct(ExpirationService $expirationService)
    {
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
