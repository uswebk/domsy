<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Dns\StoreRequest;
use App\Http\Requests\Client\Dns\UpdateRequest;
use App\Infrastructures\Models\Eloquent\Domain;
use App\Infrastructures\Models\Eloquent\DomainDnsRecord;
use App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryService;
use App\Infrastructures\Repositories\Domain\DomainDnsRecordRepositoryInterface;

use App\Services\Application\DnsStoreService;


use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DnsController extends Controller
{
    protected $domainIdQuery;
    protected $dnsRecordTypeQueryService;
    protected $domainDnsRecordRepository;

    public function __construct(
        Request $request,
        EloquentDnsRecordTypeQueryService $dnsRecordTypeQueryService,
        DomainDnsRecordRepositoryInterface $domainDnsRecordRepository
    ) {
        $this->middleware('can:owner,domain')->only(['new']);
        $this->middleware('can:owner,domainDnsRecord')->only(['edit', 'update','delete']);

        $this->domainIdQuery = $request->query('domain_id');

        $this->middleware(function ($request, $next) {
            view()->share([
                'greeting' => session('greeting'),
                'failing' => session('failing'),
                'domainIdQuery' => $this->domainIdQuery,
            ]);

            return $next($request);
        });

        $this->dnsRecordTypeQueryService = $dnsRecordTypeQueryService;
        $this->domainDnsRecordRepository = $domainDnsRecordRepository;
    }

    private function getDnsRecordTypeIds(): \Illuminate\Support\Collection
    {
        $dnsRecordTypes = $this->dnsRecordTypeQueryService->getAll();
        return $dnsRecordTypes->pluck('name', 'id');
    }


    public function index()
    {
        $domains = Auth::user()->domains;
        $domains->load([
            'domainDnsRecords',
            'domainDnsRecords.dnsRecordType'
        ]);

        if (isset($this->domainIdQuery)) {
            $domains = $domains->where('id', $this->domainIdQuery);
        }

        return view('client.dns.index', compact('domains'));
    }

    public function new(Domain $domain)
    {
        $dnsTypeIds = $this->getDnsRecordTypeIds();

        return view('client.dns.new', compact('domain', 'dnsTypeIds'));
    }

    public function edit(DomainDnsRecord $domainDnsRecord)
    {
        $dnsTypeIds = $this->getDnsRecordTypeIds();

        return view('client.dns.edit', compact('domainDnsRecord', 'dnsTypeIds'));
    }

    public function update(
        UpdateRequest $request,
        DomainDnsRecord $domainDnsRecord,
    ) {
        $attributes = $request->only([
            'subdomain',
            'type_id',
            'value',
            'ttl',
            'priority',
        ]);

        $domainDnsRecord->fill($attributes);

        $this->domainDnsRecordRepository->save($domainDnsRecord);

        return redirect()->route('dns.index', ['domain_id' => $this->domainIdQuery])
        ->with('greeting', 'Create!!');
    }

    public function store(
        StoreRequest $request,
        DnsStoreService $dnsStoreService
    ) {
        try {
            $dnsStoreService->handle(
                $request->subdomain,
                $request->domain_id,
                $request->type_id,
                $request->value,
                $request->ttl,
                $request->priority,
            );
        } catch (Exception $e) {
            throw $e;
        }

        return redirect()->route('dns.index', ['domain_id' => $this->domainIdQuery])
        ->with('greeting', 'Update!!');
    }

    public function delete(DomainDnsRecord $domainDnsRecord)
    {
        $this->domainDnsRecordRepository->delete($domainDnsRecord);

        return redirect()->route('dns.index', ['domain_id' => $this->domainIdQuery])
        ->with('greeting', 'Delete!!');
    }
}
