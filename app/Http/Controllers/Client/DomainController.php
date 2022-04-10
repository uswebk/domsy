<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Domain\UpdateRequest;
use App\Infrastructures\Models\Eloquent\Domain;
use App\Infrastructures\Repositories\Domain\DomainRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    protected $domainRepository;

    public function __construct(
        DomainRepository $domainRepository
    ) {
        $this->middleware('can:owner,domain')->except(['index', 'new','create']);

        $this->middleware(function ($request, $next) {
            view()->share('greeting', session('greeting'));

            return $next($request);
        });

        $this->domainRepository = $domainRepository;
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
        $inputs = $request->only([
            'name',
            'price',
            'is_active',
            'is_transferred',
            'is_management_only',
            'purchased',
            'expired_date',
            'canceled_at',
        ]);

        $domain->fill($inputs);

        $this->domainRepository->save($domain);

        return redirect()->route('domain.index')
        ->with('greeting', 'Success!!');
    }

    public function new()
    {
        return view('client.domain.new');
    }

    public function create(Request $request)
    {
        // Form Validation
        // Repository Add

        return redirect()->route('domain.index')
        ->with('greeting', 'Success!!');
    }
}
