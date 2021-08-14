<?php

namespace Tests\Integration;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testBasicTest(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
