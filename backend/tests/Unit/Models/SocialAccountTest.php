<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SocialAccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_users(): void
    {
        $socialAccount = SocialAccount::factory()->for(User::factory())->create();

        $this->assertTrue($socialAccount->user()->exists());
    }
}
