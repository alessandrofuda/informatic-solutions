<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase; 
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CmsVideocitofoniPageTest extends TestCase {
    
    use RefreshDatabase;

    public function test_cms_page_works_correctly() {

        $this->withoutExceptionHandling();
        
        $post = factory(Post::class)->create(['slug' => 'videocitofoni']);
        $response = $this->get('videocitofoni');
        $response->assertStatus(200);
    }

    public function test_404_if_page_dont_exist() {
        $response_404 = $this->get('any-other-slug');
        $response_404->assertStatus(404);
    }

    public function test_article_slug_is_unique() {

        // !! to solve 419 status code token mismatch, due to ajax call.
        $this->withoutMiddleware(); // Alternative: convert ajax call URL to API, because this bypass the web middleware and switch to api middleware

        $author = factory(User::class)->create(['role' => 'author']);
        $article = factory(Post::class)->create(['slug' => 'slug-1']);
        $this->assertCount(1, Post::all());

        $response = $this->actingAs($author)->json('POST', '/cms-backend/save-article-slug',['slug' => 'slug-1']);
        $response->assertJsonValidationErrors(['slug']);
        $response->assertStatus(422);
        $this->assertCount(1, Post::all());

        $response2 = $this->actingAs($author)->json('POST', '/cms-backend/save-article', ['slug' => 'slug-1']);
        $response->assertJsonValidationErrors(['slug']);
        $response->assertStatus(422);
        $this->assertCount(1, Post::all());

    }

}
