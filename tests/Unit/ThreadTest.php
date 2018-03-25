<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
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

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',  $this->thread->replies);

    }

    public function test_a_thread_has_creator()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\User',$this->thread->creator );

    }

    public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
             'body'=>'Foobar',
             'user_id'=>1
        ]);

        $this->assertCount(1,$this->thread->replies);
    }

    public function test_a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel',$thread->channel);
    }

    public function a_thread_can_make_a_string_path()
    {
        $thread = create ('App\Thread');

        $thread->assertInstanceOf("/threads/{$thread->channel->slug}/{$thread->id}" . $thread->id,$thread->path());

    }
}
