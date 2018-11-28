<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ADMIN = 1;
    const NORMAL = 0;

    const IS_ACTIVE = 0;
    const IS_BANED = 1;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function add($fields)
    {

        $user = new static;
        $user->fill($fields);
        $user->passwors = bcrypt($fields['password']);
        $user->save();

        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->passwors = bcrypt($fields['password']);
        $this->save();
    }

    public function remove()
    {
        $this->delete();
    }

    public function uploadImage($image)
    {
        if($image == null) return;
        Storage::delete('uploads/' . $this->image);
        $filename = str_random(12) . '.' . $this->image;
        $image->saveAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }

    public function getImage()
    {
        return $this->image == null ? '/img/no-user-image.png' : $this->image;
    }

    private function makeAdmin()
    {
        $this->is_admin = USER::ADMIN;
        $this->save();
    }

    private function makeNormal()
    {
        $this->is_admin = USER::NORMAL;
        $this->save();
    }

    public function toggleAdmin($value)
    {
        return $value == 0 ? $this->makeNormal() : $this->makeAdmin();
    }

    private function ban()
    {
        $this->status = USER::IS_BANED;
        $this->save();
    }

    private function unban()
    {
        $this->status = USER::IS_ACTIVE;
        $this->save();
    }

    public function toggleBan($value)
    {
        return $value == null ? $this->unban() : $this->ban();
    }
}
