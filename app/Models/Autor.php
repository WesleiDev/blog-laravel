<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $fillable = ['nome', 'image'];

    protected $appends = ['url_image'];

    public function getUrlImageAttribute(){
        if($this->attributes['image'] === null){
            return '/images/avatar_default.jpg';
        }else{
            return env('APP_URL').'/documentos/autor/'.$this->attributes['image'];
        }
    }
}
