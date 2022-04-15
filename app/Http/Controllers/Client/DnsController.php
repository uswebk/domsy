<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\DNS\StoreRequest;
use App\Infrastructures\Models\Eloquent\Domain;
use App\Infrastructures\Queries\DNS\EloquentDnsRecordTypeQueryService;
use App\Services\Application\DnsStoreService;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DnsController extends Controller
{
    protected $domainIdQuery;

    public function __construct(Request $request)
    {
        $this->middleware('can:owner,domain')->except(['index', 'store']);

        $this->domainIdQuery = $request->query('domain_id');

        $this->middleware(function ($request, $next) {
            view()->share([
                'greeting' => session('greeting'),
                'failing' => session('failing'),
                'domainIdQuery' => $this->domainIdQuery,
            ]);

            return $next($request);
        });
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

    public function new(
        Request $request,
        Domain $domain,
        EloquentDnsRecordTypeQueryService $dnsRecordTypeQueryService
    ) {
        $dnsRecordTypes = $dnsRecordTypeQueryService->getAll();
        $dnsTypeIds = $dnsRecordTypes->pluck('name', 'id');

        return view('client.dns.new', compact('domain', 'dnsTypeIds'));
    }

    public function store(
        StoreRequest $request,
        DnsStoreService $dnsStoreService
    ) {
        try {
            $attributes = $request->only([
                'subdomain',
                'domain_id',
                'type_id',
                'value',
                'ttl',
                'priority',
            ]);

            $dnsStoreService->handle($attributes);
        } catch (Exception $e) {
            throw $e;
        }

        return redirect()->route('dns.index', ['domain_id' => $this->domainIdQuery])
        ->with('greeting', 'Create!!');
    }
}
