<?php

declare(strict_types=1);

namespace App\Console\Commands\Notification\Domain;

use App\Services\Application\Commands\Notification\Domain\ExpirationService;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class Expiration extends Command
{
    protected $signature = 'notification:domain_expiration {targetDate?}';

    protected $expirationService;

    /**
     * Undocumented function
     *
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
        $targetDateArgument = $this->argument('targetDate');

        if (isset($targetDateArgument)) {
            $targetDate = new Carbon($targetDateArgument);
        } else {
            $targetDate = new Carbon();
        }

        $this->expirationService->handle($targetDate);
    }
}
