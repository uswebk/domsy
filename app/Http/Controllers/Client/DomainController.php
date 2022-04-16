<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Domain\StoreRequest;
use App\Http\Requests\Client\Domain\UpdateRequest;
use App\Infrastructures\Models\Eloquent\Domain;
use App\Infrastructures\Repositories\Domain\DomainRepositoryInterface;
use App\Services\Application\DomainStoreService;

use Exception;

use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    protected $domainRepository;

    protected const INDEX_ROUTE = 'domain.index';

    public function __construct(
        DomainRepositoryInterface $domainRepository
    ) {
        parent::__construct();

        $this->middleware('can:owner,domain')->except(['index', 'new','store']);

        $this->domainRepository = $domainRepository;
    }

    public function index()
    {
        $domains = Auth::user()->domains;

        return view('client.domain.index', compact('domains'));
    }

    public function new()
    {
        return view('client.domain.new');
    }

    public function edit(Domain $domain)
    {
        return view('client.domain.edit', compact('domain'));
    }

    public function update(
        UpdateRequest $request,
        Domain $domain,
    ) {
        try {
            $attributes = $request->only([
                'name',
                'price',
                'is_active',
                'is_transferred',
                'is_management_only',
                'purchased_at',
                'expired_at',
                'canceled_at',
            ]);

            $domain->fill($attributes);

            $this->domainRepository->save($domain);
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Update Failed!!');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Update Success!!');
    }

    public function store(
        StoreRequest $request,
        DomainStoreService $domainStoreService
    ) {
        try {
            $domainStoreService->handle(
                $request->name,
                $request->price,
                $request->user_id,
                $request->is_active,
                $request->is_transferred,
                $request->is_management_only,
                $request->purchased_at,
                $request->expired_at,
                $request->canceled_at,
            );
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Create Failed!!');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Create Success!!');
    }

    public function delete(Domain $domain)
    {
        try {
            $this->domainRepository->delete($domain);
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Delete Failed!!');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Delete Success!!');
    }
}
