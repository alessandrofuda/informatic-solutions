<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CmsVideocitofoniPageTest extends TestCase {
    
    public function test_videocitofoni_page_works_correctly() {

        $response = $this->get('/videocitofoni');
        $response->assertStatus(200);
    }
}
