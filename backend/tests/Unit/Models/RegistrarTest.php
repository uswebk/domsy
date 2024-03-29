<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Domain;
use App\Models\Registrar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class RegistrarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_user()
    {
        $user = User::factory()->create();
        $registrar = Registrar::factory(['user_id' => $user->id])->create();

        $this->assertTrue($registrar->user()->exists());
    }

    /** @test */
    public function it_has_many_domain()
    {
        $registrar = Registrar::factory()->has(Domain::factory()->count(5))->create();

        $this->assertTrue($registrar->domains()->exists());
    }
}
