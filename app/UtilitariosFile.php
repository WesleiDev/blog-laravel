<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento3
 * Date: 01/03/2018
 * Time: 15:13
 */
namespace App;

use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UtilitariosFile
{
    public static $extensoes = ['jpg', 'jpeg', 'png', 'gif'];
    public static $pathFiles = ['foto_produtos' => 'imagens/produtos',
                                'parametros' => 'imagens/parametros/logo'
                                ];

    /**
     * salva uma imagem no storage da google
     * @param $arquivo - imagem que será salva
     * @param $registro - o elloquent que será salvo a url e pego o id
     * @throws - Erro caso a extensão não seja permitida
     * @throws - Erro caso a classe não esteja no array $pathfiles
     * @throws - Erro caso não seja possível salvar a imagem por algum problema
     * @return array - retorno um array contendo a url e o nomeImagem que serão salvos no banco.
     */
    static function storeFileImage($arquivo, $registro){
        $result = [ 'url' => '',
                    'nomeImagem' => ''];

        $tamanhoarquivo = getimagesize($arquivo);
        $width = $tamanhoarquivo[0];
        $height = $tamanhoarquivo[1];
        $extensao = $arquivo->extension();
        if(!self::validaExtensao($extensao)){
            throw new \Exception('Extensão não permitida!');
        }
        $classe = ($registro->getTable());
        if(!isset(self::$pathFiles[$classe])){
            throw new \Exception('Classe não está na lista prevista para imagens');
        }
        $pathFile = self::$pathFiles[$classe].'/'.Auth::user()->empresa_id.'/';
        $nomeFile = self::makeNameFile($registro->id);
        $nomeFile = $nomeFile.'.'.$arquivo->extension();

        $disk = Storage::disk('gcs');
            if($width > 900 || $height > 900){
                try{
                    self::smart_resize_image($arquivo,null, 900, 900, true, public_path('imagens/'.$nomeFile));
                    $newImage = new File(public_path('imagens/'.$nomeFile));
                    $disk->putFileAs($pathFile, $newImage, $nomeFile, 'public');
                    unlink(public_path('imagens/'.$nomeFile));
                }catch (\Exception $e){
                    unlink(public_path('imagens/'.$nomeFile));
                    throw new \Exception('Não foi possível salvar a imagem!');
                }
            }else{
                try{
                    $disk->putFileAs($pathFile, $arquivo, $nomeFile, 'public');
                }catch (\Exception $e){
                    throw new \Exception('Não foi possível salvar a imagem');
                }
            }
            $result['url'] = $disk->url($pathFile.$nomeFile);
            $result['nomeImagem'] = $nomeFile;

        return $result;
    }
    /**
     * remove arquivo que é passado pelos parametros
     * @param  $nomearquivo - nome do arquivo que será deletado
     * @param  $registro - o elloquent que será excluido o file
     * @return boolean
     */

    static function removeFile($nomearquivo, $registro){
        if(!$nomearquivo){
            return false;
        }
        $classe = ($registro->getTable());
        $disk = Storage::disk('gcs');
        $pathFile = self::$pathFiles[$classe].'/'.Auth::user()->empresa_id.'/'.$nomearquivo;
        $result = $disk->delete($pathFile);
        return $result;
    }

    /**
     * monta o nome de um arquivo para salvar na nuvem
     * @param  $registro_id - id do registro para conter no nome do arquivo
     * @return string
     */
    static function makeNameFile($registro_id){
        $now = Carbon::now('America/Sao_Paulo');
        $now = str_replace(':', '', $now);
        $now = str_replace(' ', '', $now);
        $now = str_replace('-', '', $now);
        $rand = rand(111111111,999999999);
        $nomeArquivo = Auth::user()->empresa_id.$registro_id.'_'.$now.$rand;
        return $nomeArquivo;
    }

    /**
     * valida extensão de arquivos
     * @param  $extensao - extensao a ser validada
     * @return boolean
     */
    static function validaExtensao($extensao){
        if(in_array($extensao, self::$extensoes)){
            return true;
        }
        return false;
    }

    /**
     * easy image resize function
     * @param  $file - file name to resize
     * @param  $string - The image data, as a string
     * @param  $width - new image width
     * @param  $height - new image height
     * @param  $proportional - keep image proportional, default is no
     * @param  $output - name of the new file (include path if needed)
     * @param  $delete_original - if true the original image will be deleted
     * @param  $use_linux_commands - if set to true will use "rm" to delete the image, if false will use PHP unlink
     * @param  $quality - enter 1-100 (100 is best quality) default is 100
     * @param  $grayscale - if true, image will be grayscale (default is false)
     * @return boolean|resource
     */
    static function smart_resize_image($file,
                                $string             = null,
                                $width              = 0,
                                $height             = 0,
                                $proportional       = false,
                                $output             = 'file',
                                $delete_original    = true,
                                $use_linux_commands = false,
                                $quality            = 80,
                                $grayscale          = false
    ) {
        if ( $height <= 0 && $width <= 0 ) return false;
        if ( $file === null && $string === null ) return false;
        # Setting defaults and meta
        $info                         = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
        $image                        = '';
        $final_width                  = 0;
        $final_height                 = 0;
        list($width_old, $height_old) = $info;
        $cropHeight = $cropWidth = 0;
        # Calculating proportionality
        if ($proportional) {
            if      ($width  == 0)  $factor = $height/$height_old;
            elseif  ($height == 0)  $factor = $width/$width_old;
            else                    $factor = min( $width / $width_old, $height / $height_old );
            $final_width  = round( $width_old * $factor );
            $final_height = round( $height_old * $factor );
        }
        else {
            $final_width = ( $width <= 0 ) ? $width_old : $width;
            $final_height = ( $height <= 0 ) ? $height_old : $height;
            $widthX = $width_old / $width;
            $heightX = $height_old / $height;

            $x = min($widthX, $heightX);
            $cropWidth = ($width_old - $width * $x) / 2;
            $cropHeight = ($height_old - $height * $x) / 2;
        }
        # Loading image to memory according to type
        switch ( $info[2] ) {
            case IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  break;
            case IMAGETYPE_GIF:   $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  break;
            case IMAGETYPE_PNG:   $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  break;
            default: return false;
        }

        # Making the image grayscale, if needed
        if ($grayscale) {
            imagefilter($image, IMG_FILTER_GRAYSCALE);
        }

        # This is the resizing/resampling/transparency-preserving magic
        $image_resized = imagecreatetruecolor( $final_width, $final_height );
        if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
            $transparency = imagecolortransparent($image);
            $palletsize = imagecolorstotal($image);
            if ($transparency >= 0 && $transparency < $palletsize) {
                $transparent_color  = imagecolorsforindex($image, $transparency);
                $transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                imagefill($image_resized, 0, 0, $transparency);
                imagecolortransparent($image_resized, $transparency);
            }
            elseif ($info[2] == IMAGETYPE_PNG) {
                imagealphablending($image_resized, false);
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                imagefill($image_resized, 0, 0, $color);
                imagesavealpha($image_resized, true);
            }
        }
        imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);


        # Taking care of original, if needed
        if ( $delete_original ) {
            if ( $use_linux_commands ) exec('rm '.$file);
            else @unlink($file);
        }
        # Preparing a method of providing result
        switch ( strtolower($output) ) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
                break;
            case 'file':
                $output = $file;
                break;
            case 'return':
                return $image_resized;
                break;
            default:
                break;
        }

        # Writing image according to type to the output destination and image quality
        switch ( $info[2] ) {
            case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
            case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, $quality);   break;
            case IMAGETYPE_PNG:
                $quality = 9 - (int)((0.9*$quality)/10.0);
                imagepng($image_resized, $output, $quality);
                break;
            default: return false;
        }
        return true;
    }

}