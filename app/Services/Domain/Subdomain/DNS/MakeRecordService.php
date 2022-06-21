<?php

declare(strict_types=1);

namespace App\Services\Domain\Subdomain\DNS;

use Illuminate\Support\Collection;

final class MakeRecordService
{
    /**
     * @param \App\Infrastructures\Models\Eloquent\Subdomain $subdomain
     * @return \Illuminate\Support\Collection
     */
    public function make(
        \App\Infrastructures\Models\Eloquent\Subdomain $subdomain
    ): \Illuminate\Support\Collection {
        $dnsRecordCollection = new Collection();
        $name = $subdomain->getFullDomainName();

        $dnsValues = [];
        $dnsValues = array_merge($dnsValues, dns_get_record($name, DNS_NS));
        $dnsValues = array_merge($dnsValues, dns_get_record($name, DNS_A));
        $dnsValues = array_merge($dnsValues, dns_get_record($name, DNS_MX));
        $dnsValues = array_merge($dnsValues, dns_get_record($name, DNS_AAAA));
        $dnsValues = array_merge($dnsValues, dns_get_record($name, DNS_CNAME));
        $dnsValues = array_merge($dnsValues, dns_get_record($name, DNS_TXT));

        foreach ($dnsValues as $dnsValue) {
            $dnsRecordCollection->push(new RecordService($dnsValue));
        }

        return $dnsRecordCollection;
    }
}
