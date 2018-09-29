<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento3
 * Date: 01/03/2018
 * Time: 15:13
 */
namespace App;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class UtilitariosFile
{
    public static function saveImage($image, $tipo){
        try{
            if(isset($image)){
                $currentDate = Carbon::now()->toDateString();
                $imageName  = $tipo.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

                if(!Storage::disk('public')->exists('post'))
                {
                    Storage::disk('public')->makeDirectory('post');
                }

                $postImage = Image::make($image)->resize(1600,1066)->stream();
                Storage::disk('public')->put('/documentos/'.$tipo.'/'.$imageName,$postImage);
            }else{
                $imageName = null;
            }

            return ['nome_imagem' => $imageName];
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