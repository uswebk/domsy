<?php

declare(strict_types=1);

namespace App\Services\Domain\Subdomain\DNS;

use Illuminate\Support\Collection;

final class MakeRecordService
{
    /**
     * @param \App\Infrastructures\Models\Subdomain $subdomain
     * @return \Illuminate\Support\Collection
     */
    public function make(
        \App\Infrastructures\Models\Subdomain $subdomain
    ): \Illuminate\Support\Collection {
        $dnsValues = [];
        $name = $subdomain->getFullDomainName();
        if ($nsRecords = @dns_get_record($name, DNS_NS)) {
            $dnsValues = array_merge($dnsValues, $nsRecords);
        }
        if ($cnameRecords = @dns_get_record($name, DNS_CNAME)) {
            $dnsValues = array_merge($dnsValues, $cnameRecords);
        }
        if ($aRecords = @dns_get_record($name, DNS_A)) {
            $dnsValues = array_merge($dnsValues, $aRecords);
        }
        if ($mxRecords = @dns_get_record($name, DNS_MX)) {
            $dnsValues = array_merge($dnsValues, $mxRecords);
        }
        if ($aaaaRecords = @dns_get_record($name, DNS_AAAA)) {
            $dnsValues = array_merge($dnsValues, $aaaaRecords);
        }
        if ($txtRecords = @dns_get_record($name, DNS_TXT)) {
            $dnsValues = array_merge($dnsValues, $txtRecords);
        }

        $dnsRecords = new Collection();
        foreach ($dnsValues as $dnsValue) {
            $dnsRecords->push(new RecordService($dnsValue));
        }

        return $dnsRecords;
    }
}
