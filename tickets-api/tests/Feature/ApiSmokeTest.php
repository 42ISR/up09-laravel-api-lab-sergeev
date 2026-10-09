<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiSmokeTest extends TestCase
{
    public function test_api_root_is_available(): void
    {
        $response = $this->getJson('/');

        $response->assertOk()
            ->assertJsonPath('app', 'Tickets API');
    }
}
