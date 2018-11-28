<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use Sluggable;

    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;

    const IS_FEATURED = 1;
    const IS_STANDART = 0;

    protected $fillable = ['title', 'content'];

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function author()
    {
        return $this->hasOne(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
            'post_id',
            'tag_id'
        );
    }

    public static function add($fields)
    {

        $post = new static;
        $post->fill($fields);
        $post->user_id = 1;
        $post->save();

        return $post;
    }

    public function edit($fields)
    {

        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        Storage::delete('uploads/' . $this->image);
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

    public function setCategory($id)
    {
        if($id == null) return;
        $this->category_id = $id;
        $this->save();
    }

    public function setTags($ids)
    {
        if($ids == null) return;
        $this->tags()->sync($ids);
    }

    private function setDraft()
    {
        $this->status = Post::IS_DRAFT;
        $this->save();
    }

    private function setPublic()
    {
        $this->status = Post::IS_PUBLIC;
        $this->save;
    }

    public function toggleStatus($value)
    {
        return $value == null ? $this->setDraft() : $this->setPublic();
    }

    private function setFeatured()
    {
        $this->is_featured = POST::IS_FEATURED;
        $this->save();
    }

    private function setStandart()
    {
        $this->is_standart = POST::IS_STANDART;
        $this->save();
    }

    public function toggleFeatured($value)
    {
        return $value == null ? $this->setStandart() : $this->setFeatured();
    }

    public function getImage()
    {
        return $this->image == null ? '/img/no-image.png' : $this->image;
    }
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
