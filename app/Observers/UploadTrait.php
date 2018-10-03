<?php

namespace App\Observers;

use App\UtilitariosFile;
use Illuminate\Database\Eloquent\Model;

trait UploadTrait{
    public function saveImage(Model $model){
        try{
            if($model->image){
                $model->image = UtilitariosFile::saveImage($model);
            }
        }catch(\Exception $e){
            throw new \Exception('Erro no ao realizar upload da imagem: '.$e->getMessage());
        }
    }

    public function updateImage(Model $model){
        try{
            $image_original = $model->getOriginal('image');

            if($model->image){
                $model->image = UtilitariosFile::saveImage($model);
                UtilitariosFile::removeImage($image_original, $model->getTable());
            }else{
                $model->image = $image_original;
            }
        }catch(\Exception $e){
            throw new \Exception('Erro no ao realizar upload da imagem: '.$e->getMessage());
        }
    }

    public function removeImage(Model $model){
        try{
            UtilitariosFile::removeImage($model->image, $model->getTable());
        }catch(\Exception $e){
            throw new \Exception('Erro no ao realizar upload da imagem: '.$e->getMessage());
        }
    }
}