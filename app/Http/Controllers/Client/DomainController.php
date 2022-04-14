<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Domain\StoreRequest;
use App\Http\Requests\Client\Domain\UpdateRequest;
use App\Infrastructures\Models\Eloquent\Domain;

use App\Infrastructures\Repositories\Domain\DomainRepositoryInterface;

use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    protected $domainRepository;

    public function __construct(
        DomainRepositoryInterface $domainRepository
    ) {
        $this->middleware('can:owner,domain')->except(['index', 'new','store']);

        $this->middleware(function ($request, $next) {
            view()->share('greeting', session('greeting'));

            return $next($request);
        });

        $this->domainRepository = $domainRepository;
    }

    protected function redirectIndexWithGreeting(string $greetingMessage): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('domain.index')
        ->with('greeting', $greetingMessage);
    }

    public function index()
    {
        return view('client.domain.index', [
            'domains' => Auth::user()->domains
        ]);
    }

    public function edit(Domain $domain)
    {
        return view('client.domain.edit', [
            'domain' => $domain
        ]);
    }

    public function update(UpdateRequest $request, Domain $domain)
    {
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

        return $this->redirectIndexWithGreeting('Update Success!!');
    }

    public function new()
    {
        return view('client.domain.new');
    }

    public function store(StoreRequest $request)
    {
        $attributes = $request->only([
            'name',
            'price',
            'user_id',
            'is_active',
            'is_transferred',
            'is_management_only',
            'purchased_at',
            'expired_at',
            'canceled_at',
        ]);

        $this->domainRepository->store($attributes);

        return $this->redirectIndexWithGreeting('Create Success!!');
    }

    public function delete(Domain $domain)
    {
        $this->domainRepository->delete($domain);

        return $this->redirectIndexWithGreeting('Delete Success!!');
    }
}
