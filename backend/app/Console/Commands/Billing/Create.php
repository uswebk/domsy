<?php

declare(strict_types=1);

namespace App\Console\Commands\Billing;

use App\Services\Application\Commands\Billing\CreateService;
use Carbon\Carbon;
use Illuminate\Console\Command;

final class Create extends Command
{
    protected $signature = 'billing:create {executeDate}';

    private CreateService $createService;

    /**
     * @param CreateService $createService
     */
    public function __construct(CreateService $createService)
    {
        parent::__construct();

        $this->createService = $createService;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $executeDate = new Carbon($this->argument('executeDate'));

        $this->createService->handle($executeDate);
    }
}
