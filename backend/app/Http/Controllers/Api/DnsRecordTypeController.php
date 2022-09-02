<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\DnsRecordTypeResource;
use Illuminate\Http\Response;

final class DnsRecordTypeController
{
    /**
     * @param \App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryServiceInterface $eloquentDnsRecordTypeQueryService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetch(
        \App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryServiceInterface $eloquentDnsRecordTypeQueryService
    ) {
        $dnsRecordType = $eloquentDnsRecordTypeQueryService->getSortAll();

        return response()->json(
            DnsRecordTypeResource::collection($dnsRecordType),
            Response::HTTP_OK
        );
    }
}
