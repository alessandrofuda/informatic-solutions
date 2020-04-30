<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomepageTest extends TestCase {

    /** @test */
    public function test_homepage_works_correctly() {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('homepage');
        $response->assertViewHas('page_type', 'homepage');
    }

    public function test_homepage_links_presence() {
        $response = $this->get('/');
        $response->assertSee('/videocitofoni"');
        $response->assertSee('/videocitofoni/comparatore-prezzi"');
    }
}
