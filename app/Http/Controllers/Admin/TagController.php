<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Utilitarios;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class TagController extends Controller
{
    protected $tag;

    public function __construct(Tag $tag){
        $this->tag = $tag;
    }

    public function index(){
        return view('admin.tag.index');

    }

    public function adicionar(){
        return view('admin.tag.adicionar');
    }
    public function consultar()
    {

        $model = Tag::select(['id','nome']);

        $response = DataTables::eloquent($model)
            ->blacklist(['acoes'])
            ->toJson();

        $registros = $response->original['data'];
        foreach ($registros as $index =>$tag){
            $registros[$index]['acoes'] = Utilitarios::getBtnAction([
                ['tipo'=> 'editar', 'nome'=> 'Editar', 'class'=> 'fa fa-edit fa-2x', 'url'=>route('admin.tag.editar', [$tag['id']]),'disabled'=>true],
                ['tipo'=> 'excluir', 'nome'=> 'Excluir', 'class'=> 'fa fa-remove fa-2x', 'url'=> '', 1,'disabled'=>true],
            ]);
        }
        $response->original['data'] = $registros;

        return $response->original;
    }
    public function salvar(Request $request){
        try{
            Tag::create($request->all());

        }catch(\Exception $e){
            dd('Erro ao salvar: '.$e->getMessage());
        }
        return redirect()->route('admin.tags');
    }

    public function atualizar(Request $request){
        try{
            $data = $request->all();

            Tag::find($data['id'])->update($data);

        }catch(\Exception $e){
            dd('Erro ao atualizar: '.$e->getMessage());
        }
        return redirect()->route('admin.tags');
    }

    public function editar(Tag $tag){
        return view('admin.tag.editar', compact('tag'));

    }

}
