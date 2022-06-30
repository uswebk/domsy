<?php

declare(strict_types=1);

namespace App\Http\Controllers\Temporarily;

final class VueTestController
{
    public function index()
    {
        return view('tmp.vue.index');
    }

    public function api()
    {
        return response()->json(
            ['test' => 'ok'],
        );
    }
}
