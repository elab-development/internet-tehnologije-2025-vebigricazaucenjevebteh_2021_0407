<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NivoTest extends TestCase
{

     use RefreshDatabase;
    public function test_nivos_route_returns_success()
    {
        $response = $this->getJson('/api/nivos');

        $response->assertStatus(200);
    }

    public function test_nivos_returns_array()
    {
        $response = $this->getJson('/api/nivos');

        $response->assertStatus(200)
                 ->assertJsonIsArray();
    }
}
