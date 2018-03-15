<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;


    public function test_guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->post('/threads')->assertRedirect('/login');

        $this->get('/threads/create')->assertRedirect('/login');

    }

    public function test_an_auth_user_can_create_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $response =  $this->post('/threads',$thread->toArray());

        $this->get($response->headers->get("Location"))
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }

    function a_thread_requires_a_title()
    {
         $this->publishThread(['title'=>null])
             ->assertSessionHasErrors('title');

    }

    function a_thread_requires_a_body()
    {
        $this->publishThread(['body'=>null])
            ->assertSessionHasErrors('body');

    }
    function a_thread_requires_valid_channel()
    {
        factory('App\Channel',2)->create();

        $this->publishThread(['channel_id'=>null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id'=>999])
            ->assertSessionHasErrors('channel_id');

    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = $this->make('App\Thread',$overrides);

       return $this->post('/threads',$thread->toArray());
    }

}
