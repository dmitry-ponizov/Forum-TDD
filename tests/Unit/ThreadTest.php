<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\Notification;
use Tests\TestCase;



class ThreadTest extends TestCase
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

    public function test_a_thread_has_replies()
    {

        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);

    }

    public function test_a_thread_has_creator()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\User', $this->thread->creator);

    }

    public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function test_a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    public function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');

        $thread->assertInstanceOf("/threads/{$thread->channel->slug}/{$thread->id}" . $thread->id, $thread->path());

    }

    public function test_a_thread_can_be_subscribed_to()
    {
        $thread = create('App\Thread');

        $thread->subscribe($userId = 1);

        $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id', $userId)->count()
        );

    }


    function test_a_thread_can_be_unsubscribed_from()
    {
        $thread = create('App\Thread');

        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

        $this->assertCount(0, $thread->subscriptions);
    }

    function test_it_know_if_the_auth_user_is_subscribed_to_it()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);



    }

   public function test_a_thread_notifies_all_registered_subscribes_when_a_reply_is_added()
   {
       \Illuminate\Support\Facades\Notification::fake();

       $this->signIn()->thread->subscribe()->addReply([
           'body' => 'Foobar',
           'user_id' => 1
       ]);

       \Illuminate\Support\Facades\Notification::assertSentTo(auth()->user(),ThreadWasUpdated::class);
   }

   public function test_a_thread_can_check_if_the_auth_user_has_read_all_replies()
   {
       $this->signIn();

       $thread = create('App\Thread');

       $this->assertTrue($thread->hasUpdatesFor(auth()->user()));

       $key = sprintf("users.%s.visits.%s",auth()->id(),$thread->id);

       cache()->forever(auth()->user()->visitedThreadCacheKey($thread), $key,Carbon::now());

       $this->assertFalse($thread->hasUpdatesFor(auth()->user()));
   }
}
