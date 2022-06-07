<?php

declare(strict_types=1);

namespace App\Http\Requests\Frontend\Dns;

use App\Http\Requests\Request;
use App\Infrastructures\Models\Eloquent\Subdomain;

class StoreRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'prefix' => 'nullable|string',
            'domain_id' => 'required|integer',
            'type_id' => 'required|integer',
            'value' => 'nullable|string',
            'ttl' => 'nullable|integer',
            'priority' => 'nullable|integer',
        ];
    }

    /**
     * @return \App\Infrastructures\Models\Eloquent\Subdomain
     */
    public function makeDto(): \App\Infrastructures\Models\Eloquent\Subdomain
    {
        $validated = $this->validated();

        if (! isset($this->prefix)) {
            $validated = array_merge($validated, [
                'prefix' => '',
            ]);
        }

        return new Subdomain($validated);
    }
}
