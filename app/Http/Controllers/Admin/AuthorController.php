<?php

namespace App\Http\Controllers\Admin;

use App\Models\Author;
use App\Utilitarios;
use App\UtilitariosFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;



class AuthorController extends Controller
{
    public function index(){
        return view('admin.author.index');

    }

    public function add(){
        return view('admin.author.add');
    }
    public function search()
    {

        $model = Author::select(['id','name', 'image']);


        $response = DataTables::eloquent($model)
            ->blacklist(['action'])
            ->addColumn('url_image',function($model){
                return "<img src=$model->url_image    />";
            })
            ->rawColumns(['url_image'])
            ->toJson();

        $records = $response->original['data'];
        foreach ($records as $index =>$author){
            $records[$index]['action'] = Utilitarios::getBtnAction([
                ['tipo'=> 'editar', 'nome'=> 'Editar', 'class'=> 'fa fa-edit fa-2x', 'url'=>route('admin.author.edit', [$author['id']]),'disabled'=>true],
                ['tipo'=> 'excluir', 'nome'=> 'Excluir', 'class'=> 'fa fa-remove fa-2x', 'url'=> $author['id'],'disabled'=>true],
            ]);
        }
        $response->original['data'] = $records;

        return $response->original;
    }
    public function save(Request $request){
        try{
            $data = $request->all();

            Author::create($data);

            \Session::flash('mensagem', ['msg'=>'Autor Salvo com successo', 'status'=>'sucesso']);
        }catch(\Exception $e){
            \Session::flash('mensagem', ['msg'=>'Erro ao salvar Autor: '.$e->getMessage(), 'status'=>'erro']);

        }
        return redirect()->route('admin.authors');
    }

    public function update(Request $request){
        try{
            $data = $request->all();
            $author = Author::find($data['id']);
            $author->update($data);


            \Session::flash('mensagem', ['msg'=>'Autor atualizado com successo', 'status'=>'sucesso']);
        }catch(\Exception $e){
            \Session::flash('mensagem', ['msg'=>'Erro ao atualizar Autor: '.$e->getMessage(), 'status'=>'erro']);
        }
        return redirect()->route('admin.authors');
    }

    public function edit(Author $author){
        return view('admin.author.edit', compact('author'));

    }

    public function delete(Author $author){
        try{
            $author->delete();
        }catch(\Exception $e){
            return Utilitarios::formatResponse('Erro ao excluir Autor: '.$e->getMessage(), false);
        }

        return Utilitarios::formatResponse('Autor Excluido com sucesso', true);
    }
}
