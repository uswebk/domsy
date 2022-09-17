<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dns;

use App\Infrastructures\Models\Subdomain;
use App\Infrastructures\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

final class ApplyService
{
    private const CHUNK_SIZE = 1000;

    /**
     * @param \App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryServiceInterface $dnsRecodeTypeQueryService
     * @param \App\Services\Domain\Subdomain\DNS\ApplyRecordService $applyRecordService
     */
    public function __construct(
        \App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryServiceInterface $dnsRecodeTypeQueryService,
        \App\Services\Domain\Subdomain\DNS\ApplyRecordService $applyRecordService
    ) {
        $this->dnsRecodeTypeQueryService = $dnsRecodeTypeQueryService;
        $this->applyRecordService = $applyRecordService;
    }

    /**
     * @return array
     */
    private function getDnsRecodeTypeNames(): array
    {
        $dnsRecordTypes = $this->dnsRecodeTypeQueryService->getSortAll();

        return $dnsRecordTypes->pluck('name', 'id')->toArray();
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $user = User::find(Auth::id());

        Subdomain::join('domains', 'subdomains.domain_id', '=', 'domains.id')
        ->whereIn('domains.user_id', $user->getMemberIds())
        ->chunk(self::CHUNK_SIZE, function (
            \Illuminate\Database\Eloquent\Collection $subdomains
        ) {
            try {
                $this->applyRecordService->execute($subdomains, $this->getDnsRecodeTypeNames());
            } catch (Exception $e) {
                throw $e;
            }
        });
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return [
            'success_list' => $this->applyRecordService->getSuccessDomains(),
            'errors_list' => $this->applyRecordService->getErrorDomains(),
        ];
    }
}
