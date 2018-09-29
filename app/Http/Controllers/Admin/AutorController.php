<?php

namespace App\Http\Controllers\Admin;

use App\Models\Autor;
use App\Utilitarios;
use App\UtilitariosFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Illuminate\Support\Facades\Storage;


class AutorController extends Controller
{
    public function index(){
        return view('admin.autor.index');

    }

    public function adicionar(){
        return view('admin.autor.adicionar');
    }
    public function consultar()
    {

        $model = Autor::select(['id','nome', 'image']);


        $response = DataTables::eloquent($model)
            ->blacklist(['acoes'])
            ->addColumn('url_image',function($model){
                return "<img src=$model->url_image    />";
            })
            ->rawColumns(['url_image'])
            ->toJson();

        $registros = $response->original['data'];
        foreach ($registros as $index =>$autor){
            $registros[$index]['acoes'] = Utilitarios::getBtnAction([
                ['tipo'=> 'editar', 'nome'=> 'Editar', 'class'=> 'fa fa-edit fa-2x', 'url'=>route('admin.autor.editar', [$autor['id']]),'disabled'=>true],
                ['tipo'=> 'excluir', 'nome'=> 'Excluir', 'class'=> 'fa fa-remove fa-2x', 'url'=> $autor['id'],'disabled'=>true],
            ]);
        }
        $response->original['data'] = $registros;

        return $response->original;
    }
    public function salvar(Request $request){
        try{
            $data = $request->all();
            $image = $request->file('image');

            $data['image'] = UtilitariosFile::saveImage($image, 'autor')['nome_imagem'];

            Autor::create($data);

            \Session::flash('mensagem', ['msg'=>'Autor Salvo com successo', 'status'=>'sucesso']);
        }catch(\Exception $e){
            \Session::flash('mensagem', ['msg'=>'Erro ao salvar Autor: '.$e->getMessage(), 'status'=>'erro']);

        }
        return redirect()->route('admin.autores');
    }

    public function atualizar(Request $request){
        try{
            $data = $request->all();
            $autor = Autor::find($data['id']);

            $image = $request->file('image');

            if(isset($image)){
                $nova_imagem = UtilitariosFile::saveImage($image, 'autor')['nome_imagem'];//Se salvar sem erros exlui a imagem na parte de baixo
                unset($data['image']);
                UtilitariosFile::removeImage($autor->image, 'autor');
                $data['image'] = $nova_imagem;
            }else{
                unset($data['image']);
            }

            $autor->update($data);


            \Session::flash('mensagem', ['msg'=>'Autor atualizado com successo', 'status'=>'sucesso']);
        }catch(\Exception $e){
            \Session::flash('mensagem', ['msg'=>'Erro ao atualizar Autor: '.$e->getMessage(), 'status'=>'erro']);
        }
        return redirect()->route('admin.autores');
    }

    public function editar(Autor $autor){
        return view('admin.autor.editar', compact('autor'));

    }

    public function delete(Autor $autor){
        try{
            UtilitariosFile::removeImage($autor->image, 'autor');
            $autor->delete();
        }catch(\Exception $e){
            return Utilitarios::formatResponse('Erro ao excluir Autor: '.$e->getMessage(), false);
        }

        return Utilitarios::formatResponse('Autor Excluido com sucesso', true);
    }
}
