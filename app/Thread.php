<?php

namespace App;

use App\Events\ThreadHasNewReply;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadWasUpdated;

/**
 * @property mixed subscriptions
 */
class Thread extends Model
{


    use RecordsActivity;

    protected $guarded = [];

    protected $appends = ['isSubscribedTo'];

    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });

    }


    public function path()
    {
        return "/threads/{$this->channel->slug}/$this->id";
    }


    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadHasNewReply($this, $reply));

        return $reply;
    }

    public function notifySubscribers($reply )
    {
        $this->subscriptions
            ->where('user_id', '!=', $reply->user_id)
            ->each->notify($reply);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()->where('user_id',auth()->id())->exists();
    }
    public function hasUpdatesFor()
    {

        $key = sprintf("users.%s.visits.%s",auth()->id(),$this->id);

        return $this->updated_at > cache($key);
    }
}
