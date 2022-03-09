<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;


class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_tiene_muchas_solicitudes_retiro()
    {
        $user = new User;

        $this->assertInstanceOf(Collection::class, $user->solicitudes_retiro);
    }

}
