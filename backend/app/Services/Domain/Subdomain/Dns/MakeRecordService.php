<?php

declare(strict_types=1);

namespace App\Services\Domain\Subdomain\Dns;

use Illuminate\Support\Collection;

class MakeRecordService
{
    /**
     * @param \App\Models\Subdomain $subdomain
     * @return Collection
     */
    public function make(
        \App\Models\Subdomain $subdomain
    ): Collection {
        $name = $subdomain->getFullDomainName();
        $dnsValues = $this->getDnsValues($name);

        $dnsRecords = new Collection();
        foreach ($dnsValues as $dnsValue) {
            $dnsRecords->push(new RecordService($dnsValue));
        }

        return $dnsRecords;
    }

    /**
     * @param string $name
     * @return array
     */
    private function getDnsValues(string $name): array
    {
        $dnsList = [];

        if ($nsRecords = @dns_get_record($name, DNS_NS)) {
            $dnsList = array_merge($dnsList, $nsRecords);
        }
        if ($cnameRecords = @dns_get_record($name, DNS_CNAME)) {
            $dnsList = array_merge($dnsList, $cnameRecords);
        }
        if ($aRecords = @dns_get_record($name, DNS_A)) {
            $dnsList = array_merge($dnsList, $aRecords);
        }
        if ($mxRecords = @dns_get_record($name, DNS_MX)) {
            $dnsList = array_merge($dnsList, $mxRecords);
        }
        if ($aaaaRecords = @dns_get_record($name, DNS_AAAA)) {
            $dnsList = array_merge($dnsList, $aaaaRecords);
        }
        if ($txtRecords = @dns_get_record($name, DNS_TXT)) {
            $dnsList = array_merge($dnsList, $txtRecords);
        }

        return $dnsList;
    }
}
