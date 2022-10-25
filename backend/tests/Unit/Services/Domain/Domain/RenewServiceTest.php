<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Domain\Domain;

use App\Infrastructures\Models\Domain;
use App\Infrastructures\Models\Subdomain;
use App\Infrastructures\Repositories\Domain\DomainRepository;
use App\Infrastructures\Repositories\Subdomain\SubdomainRepository;
use App\Services\Domain\Domain\RenewService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class RenewServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function if_domain_name_changes_recreate_subdomain(): void
    {
        $domain = Domain::factory([
            'name' => 'test.com',
        ])->create();

        Subdomain::factory([
            'domain_id' => $domain->id,
        ])->count(10)->create();

        $domain->name = 'test2.com';

        $renewService = new RenewService(new DomainRepository(), new SubdomainRepository());
        $renewService->execute($domain);

        $this->assertDatabaseCount('subdomains', 1);
        $this->assertDatabaseHas('domains', [
            'name' => 'test2.com',
        ]);
    }

    /** @test */
    public function if_domain_name_not_changes_not_recreate_subdomain(): void
    {
        $domain = Domain::factory([
            'name' => 'test.com',
        ])->create();

        Subdomain::factory([
            'domain_id' => $domain->id,
        ])->count(10)->create();

        $renewService = new RenewService(new DomainRepository(), new SubdomainRepository());
        $renewService->execute($domain);

        $this->assertDatabaseCount('subdomains', 10);
        $this->assertDatabaseHas('domains', [
            'name' => 'test.com',
        ]);
    }
}
