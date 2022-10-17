<?php

namespace Tests\Unit\Models;

use App\Models\Sector;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SectorTest extends TestCase
{
    use RefreshDatabase;

    public function test_tienen_muchas_empresas()
    {
        $sector = new Sector();
        $this->assertInstanceOf(Collection::class, $sector->empresas);
    }

}
