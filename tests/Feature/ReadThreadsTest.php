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


    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');


        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);


        $threadNoChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNoChannel->title);
    }

    public function test_a_user_can_filter_threads_by_any_username()
    {

        $this->signIn(create('App\User', ['name' => 'admin']));

        $thread = create('App\Thread', ['user_id' => \Auth::id()]);

        $other_thread = create('App\Thread');

        $this->get('threads/?by=admin')
            ->assertSee($thread->title)
            ->assertDontSee($other_thread->title);
    }


    public function test_a_user_can_filter_threads_by_popularity()
    {

        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $response = $this->getJson('/threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));

    }
    public function test_a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');

        create('App\Reply', ['thread_id' => $thread->id], 2);

       $response =  $this->getJson($thread->path() . '/replies')->json();

       $this->assertCount(2,$response['data']);

        $this->assertEquals(2,$response['total']);
    }

    public function test_a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $thread = create('App\Thread');

        $reply = create('App\Reply',['thread_id'=>$thread->id]);

        $response = $this->getJson('/threads?unanswered=1')->json();

        $this->assertCount(1,$response['data']);
    }

}
