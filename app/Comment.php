<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    const ALLOW = 1;
    const DISALLOW = 0;

    public function post()
    {
        return $this->hasOne(Post::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function allow()
    {
        $this->status = Comment::ALLOW;
        $this->save();
    }

    public function disAllow()
    {
        $this->status = Comment::DISALLOW;
        $this->save();
    }

    public function toggleStatus()
    {
        return $this->status == Comment::DISALLOW ? $this->allow() : $this->disAllow();
    }

    public function remove()
    {
        $this->delete();
    }
}
