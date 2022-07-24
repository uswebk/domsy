<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

final class DnsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('frontend.dns.index');
    }
}
