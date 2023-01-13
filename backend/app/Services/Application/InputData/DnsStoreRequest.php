<?php

declare(strict_types=1);

namespace App\Services\Application\InputData;

use App\Http\Requests\Api\Dns\StoreRequest;
use App\Models\Subdomain;

final class DnsStoreRequest
{
    private Subdomain $subdomain;

    /**
     * @param StoreRequest $storeRequest
     */
    public function __construct(StoreRequest $storeRequest)
    {
        $validated = $storeRequest->validated();

        if (!isset($storeRequest->prefix)) {
            $validated = array_merge($validated, [
                'prefix' => '',
            ]);
        }

        $this->subdomain = new Subdomain($validated);
    }

    /**
     * @return Subdomain
     */
    public function getInput(): Subdomain
    {
        return $this->subdomain;
    }
}
