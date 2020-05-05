<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase; 

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

    public function test_article_title_is_unique() {

        $this->withoutExceptionHandling();

        $author = factory(User::class)->create(['role' => 'author']);
        $post = factory(Post::class)->create(['slug' => 'slug-1']);
        dump($author);
        dd($post);

        $this->actingAs($author)->post('/cms-backend/save-article-slug',['slug' => 'slug-1']);

        //TODO
        // assertJson contain: status => 422 // meglio: aggiungere la validazione alle post rules 


        // stessa cosa anche per l'altra POST
        //$this->actingAs($author)->post('/cms-backend/save-article', )

    }

}
