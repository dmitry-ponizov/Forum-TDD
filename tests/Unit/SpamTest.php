<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\Notification;
use Tests\TestCase;
use App\Inspections\Spam;


class SpamTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_validate_spam()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));

        $this->expectException('Exception');

        $spam->detect('Yahoo Customer support');
    }

}

