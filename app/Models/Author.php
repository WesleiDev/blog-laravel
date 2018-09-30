<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name', 'image'];

    protected $appends = ['url_image'];

    public function getUrlImageAttribute(){
        if($this->attributes['image'] === null){
            return '/images/avatar_default.jpg';
        }else{
            return env('APP_URL').'/documentos/author/'.$this->attributes['image'];
        }
    }
}
