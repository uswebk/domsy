<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\DnsRecordTypeResource;
use App\Queries\Dns\DnsRecordTypeQueryServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class DnsRecordTypeController
{
    /**
     * @param DnsRecordTypeQueryServiceInterface $dnsRecordTypeQueryService
     * @return JsonResponse
     */
    public function fetch(DnsRecordTypeQueryServiceInterface $dnsRecordTypeQueryService): JsonResponse
    {
        $dnsRecordType = $dnsRecordTypeQueryService->getSortAll();

        return response()->json(DnsRecordTypeResource::collection($dnsRecordType), Response::HTTP_OK);
    }
}
