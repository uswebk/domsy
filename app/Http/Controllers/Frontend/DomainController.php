<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Exceptions\Frontend\DomainExistsException;


use Exception;

use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    protected $domainRepository;

    protected const INDEX_ROUTE = 'domain.index';

    /**
     * @param \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
    ) {
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
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $domains = Auth::user()->domains;

        return view('frontend.domain.index', compact('domains'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function new(): \Illuminate\Contracts\View\View
    {
        return view('frontend.domain.new');
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\Domain $domain
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(
        \App\Infrastructures\Models\Eloquent\Domain $domain
    ): \Illuminate\Contracts\View\View {
        return view('frontend.domain.edit', compact('domain'));
    }

    /**
     * @param \App\Http\Requests\Frontend\Domain\UpdateRequest $request
     * @param \App\Infrastructures\Models\Eloquent\Domain $domain
     * @param \App\Services\Application\DomainUpdateService $domainUpdateService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        \App\Http\Requests\Frontend\Domain\UpdateRequest $request,
        \App\Infrastructures\Models\Eloquent\Domain $domain,
        \App\Services\Application\DomainUpdateService $domainUpdateService
    ): \Illuminate\Http\RedirectResponse {
        $domainRequest = $request->makeInput();
        try {
            $domainUpdateService->handle($domainRequest, $domain);
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Failing Update');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Update Success!!');
    }

    /**
     * @param \App\Http\Requests\Frontend\Domain\StoreRequest $request
     * @param \App\Services\Application\DomainStoreService $domainStoreService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(
        \App\Http\Requests\Frontend\Domain\StoreRequest $request,
        \App\Services\Application\DomainStoreService $domainStoreService
    ): \Illuminate\Http\RedirectResponse {
        $domainRequest = $request->makeInput();
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
     * @param \App\Infrastructures\Models\Eloquent\Domain $domain
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(
        \App\Infrastructures\Models\Eloquent\Domain $domain
    ): \Illuminate\Http\RedirectResponse {
        $this->domainRepository->delete($domain);

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Delete Success!!');
    }
}
