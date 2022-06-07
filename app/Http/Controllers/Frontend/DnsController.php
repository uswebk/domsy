<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Exceptions\Frontend\DomainNotExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Dns\StoreRequest;
use App\Http\Requests\Frontend\Dns\UpdateRequest;
use App\Infrastructures\Models\Eloquent\Domain;
use App\Infrastructures\Models\Eloquent\Subdomain;
use App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryServiceInterface;
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

    /**
     * @param Request $request
     * @param EloquentDnsRecordTypeQueryServiceInterface $dnsRecordTypeQueryService
     * @param SubdomainRepositoryInterface $subdomainRepository
     */
    public function __construct(
        Request $request,
        EloquentDnsRecordTypeQueryServiceInterface $dnsRecordTypeQueryService,
        SubdomainRepositoryInterface $subdomainRepository
    ) {
        parent::__construct();

        $this->domainIdQuery = $request->query('domain_id');

        $this->dnsRecordTypeQueryService = $dnsRecordTypeQueryService;
        $this->subdomainRepository = $subdomainRepository;

        $this->middleware('can:owner,domain')->only(['new']);
        $this->middleware('can:owner,subdomain')->only(['edit', 'update','delete']);

        $this->middleware(function ($request, $next) {
            $dnsRecordTypes = $this->dnsRecordTypeQueryService->getSortAll();

            view()->share([
                'domainIdQuery' => $this->domainIdQuery,
                'dnsTypeIds' => $dnsRecordTypes->pluck('name', 'id')->toArray(),
            ]);

            return $next($request);
        });
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
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

    /**
     * @param Domain $domain
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function new(Domain $domain): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('client.dns.new', compact('domain'));
    }

    /**
     * @param Subdomain $subdomain
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Subdomain $subdomain): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('client.dns.edit', compact('subdomain'));
    }

    /**
     * @param UpdateRequest $request
     * @param Subdomain $subdomain
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(
        UpdateRequest $request,
        Subdomain $subdomain,
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
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

    /**
     * @param StoreRequest $request
     * @param DnsStoreService $dnsStoreService
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(
        StoreRequest $request,
        DnsStoreService $dnsStoreService
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $subdomainRequest = $request->makeDto();

        try {
            $dnsStoreService->handle($subdomainRequest);
        } catch (DomainNotExistsException $e) {
            return redirect()->route('dns.index', ['domain_id' => $this->domainIdQuery])
            ->with('failing', $e->getMessage());
        } catch (Exception $e) {
            throw $e;
        }

        return redirect()->route('dns.index', ['domain_id' => $this->domainIdQuery])
        ->with('greeting', 'Update!!');
    }

    /**
     * @param Subdomain $subdomain
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(Subdomain $subdomain): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $this->subdomainRepository->delete($subdomain);

        return redirect()->route('dns.index', ['domain_id' => $this->domainIdQuery])
        ->with('greeting', 'Delete!!');
    }
}
