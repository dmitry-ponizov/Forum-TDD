<?php

namespace Tests\Feature;


use App\Activity;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;



class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;


    public function test_a_user_can_subscribe_to_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() .'/subscriptions');

        $this->assertCount(1, $thread->fresh()->subscriptions);

    }

    public function test_a_user_can_unsubscribe_to_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->subscribe();

        $this->delete($thread->path() .'/subscriptions');

        $this->assertCount(0,$thread->subscriptions);


    }

}
