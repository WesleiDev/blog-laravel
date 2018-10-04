<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'image',
        'body',
        'author_id',
        'category_id'
    ];

    protected $appends = ['url_image'];

    public function getUrlImageAttribute(){
        if($this->attributes['image'] === null){
            return '/images/image_empty.png';
        }else{
            return env('APP_URL').'/documentos/posts/'.$this->attributes['image'];
        }
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
