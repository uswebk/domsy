<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Exceptions\Frontend\DomainExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Domain\StoreRequest;
use App\Http\Requests\Frontend\Domain\UpdateRequest;
use App\Infrastructures\Models\Eloquent\Domain;
use App\Infrastructures\Repositories\Domain\DomainRepositoryInterface;
use App\Services\Application\DomainStoreService;
use App\Services\Application\DomainUpdateService;

use Exception;

use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    protected $domainRepository;

    protected const INDEX_ROUTE = 'domain.index';

    /**
     * @param DomainRepositoryInterface $domainRepository
     */
    public function __construct(DomainRepositoryInterface $domainRepository)
    {
        parent::__construct();

        $this->middleware('can:owner,domain')->except(['index', 'new','store']);

        $this->middleware(function ($request, $next) {
            $registrars = Auth::user()->registrars;

            view()->share([
                'registrarIds' => $registrars->pluck('name', 'id')->toArray(),
            ]);

            return $next($request);
        });

        $this->domainRepository = $domainRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        $domains = Auth::user()->domains;

        return view('client.domain.index', compact('domains'));
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function new(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('client.domain.new');
    }

    /**
     * @param Domain $domain
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Domain $domain): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('client.domain.edit', compact('domain'));
    }

    /**
     * @param UpdateRequest $request
     * @param Domain $domain
     * @param DomainUpdateService $domainUpdateService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        UpdateRequest $request,
        Domain $domain,
        DomainUpdateService $domainUpdateService
    ): \Illuminate\Http\RedirectResponse {
        $domainRequest = $request->makeDto();

        try {
            $domainUpdateService->handle(
                $domainRequest,
                $domain
            );
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Failing Update');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Update Success!!');
    }

    /**
     * @param StoreRequest $request
     * @param DomainStoreService $domainStoreService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(
        StoreRequest $request,
        DomainStoreService $domainStoreService
    ): \Illuminate\Http\RedirectResponse {
        $domainRequest = $request->makeDto();

        try {
            $domainStoreService->handle($domainRequest);
        } catch (DomainExistsException $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, $e->getMessage());
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Failing Create');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Create Success!!');
    }

    /**
     * @param Domain $domain
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Domain $domain): \Illuminate\Http\RedirectResponse
    {
        $this->domainRepository->delete($domain);

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Delete Success!!');
    }
}
