<?php

declare(strict_types=1);

namespace App\Console\Commands\Notification\Domain;

use App\Services\Application\Commands\Notification\Domain\ExpirationService;

use Carbon\Carbon;
use Illuminate\Console\Command;

class Expiration extends Command
{
    protected $signature = 'notification:domain_expiration {executeDate?}';

    protected $expirationService;

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
        $executeDateArgument = $this->argument('executeDate');

        if (isset($executeDateArgument)) {
            $executeDate = new Carbon($executeDateArgument);
        } else {
            $executeDate = new Carbon();
        }

        $this->expirationService->handle($executeDate);
    }
}
