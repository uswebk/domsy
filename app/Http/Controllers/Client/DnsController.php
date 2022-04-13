<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class DnsController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $domains = Auth::user()->domains;
        $domains->load([
            'domain_dns_records',
            'domain_dns_records.dns_record_type'
        ]);

        return view('client.dns.index', compact('domains'));
    }
}
