<?php

declare(strict_types=1);

namespace App\Services\Application\Api\Dns;

use App\Models\Subdomain;
use App\Models\User;
use App\Queries\Dns\DnsRecordTypeQueryServiceInterface;
use App\Services\Domain\Subdomain\Dns\ApplyRecordService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

final class ApplyService
{
    private const CHUNK_SIZE = 1000;

    private DnsRecordTypeQueryServiceInterface $dnsRecodeTypeQueryService;

    private ApplyRecordService $applyRecordService;

    /**
     * @param DnsRecordTypeQueryServiceInterface $dnsRecodeTypeQueryService
     * @param ApplyRecordService $applyRecordService
     */
    public function __construct(
        DnsRecordTypeQueryServiceInterface $dnsRecodeTypeQueryService,
        ApplyRecordService $applyRecordService
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

        Subdomain::select('subdomains.*')
            ->with(['domain'])
            ->join('domains', 'subdomains.domain_id', '=', 'domains.id')
            ->where('domains.is_fetching_dns', true)
            ->whereIn('domains.user_id', $user->getMemberIds())
            ->chunk(self::CHUNK_SIZE, function (
                Collection $subdomains
            ) {
                $this->applyRecordService->execute($subdomains, $this->getDnsRecodeTypeNames());
            });
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return [
            'success_list' => $this->applyRecordService->getSuccessDomains(),
            'error_list' => $this->applyRecordService->getErrorDomains(),
        ];
    }
}
