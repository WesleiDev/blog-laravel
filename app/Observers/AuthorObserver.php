<?php

namespace App\Observers;

use App\Models\Author;
use App\UtilitariosFile;

class AuthorObserver
{
    use UploadTrait;

    public function creating(Author $author){
        $this->saveImage($author);
    }

    public function updating(Author $author){
        $this->updateImage($author);
    }

    public function deleted(Author $author){
        $this->removeImage($author);
    }
}
