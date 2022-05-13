<?php

declare(strict_types=1);

namespace App\Console\Commands\Notification\Domain;

use App\Services\Application\Commands\Notification\Domain\ExpirationService;

use Carbon\Carbon;

use Illuminate\Console\Command;

class Expiration extends Command
{
    protected $signature = 'notification:domain_expiration {target_date?}';

    protected $expirationService;

    public function __construct(ExpirationService $expirationService)
    {
        parent::__construct();

        $this->expirationService = $expirationService;
    }

    public function handle(): void
    {
        $_target_date = $this->argument('target_date');

        if (isset($_target_date)) {
            $target_date = new Carbon($_target_date);
        } else {
            $target_date = new Carbon();
        }

        $this->expirationService->handle($target_date);
    }
}
