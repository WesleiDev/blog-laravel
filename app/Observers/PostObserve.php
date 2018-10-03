<?php

namespace App\Observers;

use App\Models\Post;

class PostObserve
{
    use UploadTrait;

    public function creating(Post $post){
        $this->saveImage($post);
    }

    public function updating(Post $post){
        $this->updateImage($post);
    }

    public function deleted(Post $post){
        $this->removeImage($post);
    }
}
