<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\DNS\StoreRequest;
use App\Infrastructures\Models\Eloquent\Domain;
use App\Infrastructures\Queries\DNS\EloquentDnsRecordTypeQueryService;
use App\Infrastructures\Repositories\Domain\DomainDnsRecordRepositoryInterface;

use Illuminate\Support\Facades\Auth;

class DnsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:owner,domain')->except(['index', 'store']);

        view()->share([
            'greeting'=> session('greeting'),
            'failing'=> session('failing')
        ]);
    }

    public function index()
    {
        $domains = Auth::user()->domains;
        $domains->load([
            'domainDnsRecords',
            'domainDnsRecords.dnsRecordType'
        ]);

        return view('client.dns.index', compact('domains'));
    }

    public function new(
        Domain $domain,
        EloquentDnsRecordTypeQueryService $dnsRecordTypeQueryService
    ) {
        $dnsRecordTypes = $dnsRecordTypeQueryService->getAll();
        $dnsTypeIds = $dnsRecordTypes->pluck('name', 'id');

        return view('client.dns.new', compact('domain', 'dnsTypeIds'));
    }

    public function store(
        StoreRequest $request,
        DomainDnsRecordRepositoryInterface $domainDnsRecordRepository
    ) {
        $attributes = $request->only([
            'subdomain',
            'domain_id',
            'type_id',
            'value',
            'ttl',
            'priority',
        ]);

        $domainDnsRecordRepository->store($attributes);

        return redirect()->route('dns.index', ['domain_id' => $request->domain_id])
        ->with('greeting', 'Create!!');
    }
}
