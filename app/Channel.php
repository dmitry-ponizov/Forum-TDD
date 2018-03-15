<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function getRouteKey()
    {
        return 'slug';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
