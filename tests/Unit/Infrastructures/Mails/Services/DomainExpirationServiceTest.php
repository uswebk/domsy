<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructures\Mails\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DomainExpirationServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function sendVerificationEmail()
    {
    }
}
