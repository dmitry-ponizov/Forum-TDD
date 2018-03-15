<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }
    public function test_a_user_can_view_all_threads()
    {
         $this->get('/threads')
            ->assertSee($this->thread->title);


    }

    public function test_user_can_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id ]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');

        $threadInChannel = create('App\Thread',['channel_id'=>$channel->id]);

        $threadNoChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNoChannel->title);
    }

    public function test_a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User',['name'=>'admin']));

        $thread = create('App\Thread',['user_id' => \Auth::id()]);

        $other_thread = create('App\Thread');

        $this->get('threads/?by=admin')
            ->assertSee($thread->title)
            ->assertDontSee($other_thread->title);
    }
}
