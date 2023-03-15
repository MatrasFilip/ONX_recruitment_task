<?php

namespace Tests\Feature;

use Tests\TestCase;

class DisplayHomePageTest extends TestCase
{
    public function testDisplayHomePage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}