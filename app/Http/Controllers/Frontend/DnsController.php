<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Exceptions\Frontend\DomainNotExistsException;
use App\Http\Controllers\Controller;

use Exception;

use Illuminate\Support\Facades\Auth;

class DnsController extends Controller
{
    protected $domainIdQuery;

    protected $dnsRecordTypeQueryService;

    protected $subdomainRepository;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryServiceInterface $dnsRecordTypeQueryService
     * @param \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
     */
    public function __construct(
        \Illuminate\Http\Request $request,
        \App\Infrastructures\Queries\Dns\EloquentDnsRecordTypeQueryServiceInterface $dnsRecordTypeQueryService,
        \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
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
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $domains = Auth::user()->domains;
        $domains->load([
            'subdomain',
            'subdomain.dnsRecordType'
        ]);

        if (isset($this->domainIdQuery)) {
            $domains = $domains->where('id', $this->domainIdQuery);
        }

        return view('frontend.dns.index', compact('domains'));
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\Domain $domain
     * @return \Illuminate\Contracts\View\View
     */
    public function new(
        \App\Infrastructures\Models\Eloquent\Domain $domain
    ): \Illuminate\Contracts\View\View {
        return view('frontend.dns.new', compact('domain'));
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\Subdomain $subdomain
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(
        \App\Infrastructures\Models\Eloquent\Subdomain $subdomain
    ): \Illuminate\Contracts\View\View {
        return view('frontend.dns.edit', compact('subdomain'));
    }

    /**
     * @param \App\Http\Requests\Frontend\Dns\UpdateRequest $request
     * @param \App\Infrastructures\Models\Eloquent\Subdomain $subdomain
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        \App\Http\Requests\Frontend\Dns\UpdateRequest $request,
        \App\Infrastructures\Models\Eloquent\Subdomain $subdomain,
    ): \Illuminate\Http\RedirectResponse {
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
     * @param \App\Http\Requests\Frontend\Dns\StoreRequest $request
     * @param \App\Services\Application\DnsStoreService $dnsStoreService
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(
        \App\Http\Requests\Frontend\Dns\StoreRequest $request,
        \App\Services\Application\DnsStoreService $dnsStoreService
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $subdomainRequest = $request->makeInput();
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
     * @param \App\Infrastructures\Models\Eloquent\Subdomain $subdomain
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(
        \App\Infrastructures\Models\Eloquent\Subdomain $subdomain
    ): \Illuminate\Http\RedirectResponse {
        $this->subdomainRepository->delete($subdomain);

        return redirect()->route('dns.index', ['domain_id' => $this->domainIdQuery])
        ->with('greeting', 'Delete!!');
    }
}
