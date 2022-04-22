<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Exceptions\Client\DomainNotExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Dns\StoreRequest;
use App\Http\Requests\Client\Dns\UpdateRequest;
use App\Infrastructures\Models\Eloquent\Domain;
use App\Infrastructures\Models\Eloquent\Subdomain;
use App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryService;
use App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface;
use App\Services\Application\DnsStoreService;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DnsController extends Controller
{
    protected $domainIdQuery;

    protected $dnsRecordTypeQueryService;
    protected $subdomainRepository;

    public function __construct(
        Request $request,
        EloquentDnsRecordTypeQueryService $dnsRecordTypeQueryService,
        SubdomainRepositoryInterface $subdomainRepository
    ) {
        parent::__construct();

        $this->domainIdQuery = $request->query('domain_id');

        $this->dnsRecordTypeQueryService = $dnsRecordTypeQueryService;
        $this->subdomainRepository = $subdomainRepository;

        $this->middleware('can:owner,domain')->only(['new']);
        $this->middleware('can:owner,subdomain')->only(['edit', 'update','delete']);

        $this->middleware(function ($request, $next) {
            $dnsRecordTypes = $this->dnsRecordTypeQueryService->getAll();

            view()->share([
                'domainIdQuery' => $this->domainIdQuery,
                'dnsTypeIds' => $dnsRecordTypes->pluck('name', 'id')->toArray(),
            ]);

            return $next($request);
        });
    }

    public function index()
    {
        $domains = Auth::user()->domains;
        $domains->load([
            'subdomain',
            'subdomain.dnsRecordType'
        ]);

        if (isset($this->domainIdQuery)) {
            $domains = $domains->where('id', $this->domainIdQuery);
        }

        return view('client.dns.index', compact('domains'));
    }

    public function new(Domain $domain)
    {
        return view('client.dns.new', compact('domain'));
    }

    public function edit(Subdomain $subdomain)
    {
        return view('client.dns.edit', compact('subdomain'));
    }

    public function update(
        UpdateRequest $request,
        Subdomain $subdomain,
    ) {
        $attributes = $request->only([
            'subdomain',
            'type_id',
            'value',
            'ttl',
            'priority',
        ]);

        $subdomain->fill($attributes);

        $this->subdomainRepository->save($subdomain);

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
        } catch (DomainNotExistsException $e) {
            return redirect()->route('dns.index', ['domain_id' => $this->domainIdQuery])
            ->with('failing', $e->getMessage());
        } catch (Exception $e) {
            throw $e;
        }

        return redirect()->route('dns.index', ['domain_id' => $this->domainIdQuery])
        ->with('greeting', 'Update!!');
    }

    public function delete(Subdomain $subdomain)
    {
        $this->subdomainRepository->delete($subdomain);

        return redirect()->route('dns.index', ['domain_id' => $this->domainIdQuery])
        ->with('greeting', 'Delete!!');
    }
}
