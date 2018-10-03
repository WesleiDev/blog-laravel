<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento3
 * Date: 01/03/2018
 * Time: 15:13
 */
namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class UtilitariosFile
{
    public static function saveImage(Model $model){
        try{
            if(!is_string($model->image) && $model->image->isValid()){
                $tipo = $model->getTable();
                $currentDate = Carbon::now()->toDateString();
                $imageName  = $tipo.'-'.$currentDate.'-'.uniqid().'.'.$model->image->getClientOriginalExtension();

                if(!Storage::disk('public')->exists('post'))
                {
                    Storage::disk('public')->makeDirectory('post');
                }

                $postImage = Image::make($model->image)->resize(1600,1066)->stream();
                Storage::disk('public')->put('/documentos/'.$tipo.'/'.$imageName,$postImage);
            }else{
                $imageName = $model->getOriginal('image');
            }

            return  $imageName;
        }catch(\Exception $e){
            throw new \Exception('Erro ao salvar imagem: '.$e->getMessage());
        }

    }

    public static function removeImage($image, $tipo){
        try{
            Storage::disk('public')->delete('/documentos/'.$tipo.'/'.$image);
        }catch(\Exception $e){
            throw new \Exception('Erro ao excluir imagem: '.$e->getMessage());
        }

    }



}