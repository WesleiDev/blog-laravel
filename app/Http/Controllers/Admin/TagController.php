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
    protected $utilitarios;
    public function __construct(Tag $tag, Utilitarios $utilitarios){
        $this->tag = $tag;
        $this->utilitarios = $utilitarios;
    }

    public function index(){
        return view('admin.tag.index');

    }

    public function add(){
        return view('admin.tag.add');
    }
    public function search()
    {

        $model = Tag::select(['id','name']);

        $response = DataTables::eloquent($model)
            ->blacklist(['action'])
            ->toJson();

        $registros = $response->original['data'];
        foreach ($registros as $index =>$tag){
            $registros[$index]['action'] = Utilitarios::getBtnAction([
                ['tipo'=> 'editar', 'nome'=> 'Editar', 'class'=> 'fa fa-edit fa-2x', 'url'=>route('admin.tag.edit', [$tag['id']]),'disabled'=>true],
                ['tipo'=> 'excluir', 'nome'=> 'Excluir', 'class'=> 'fa fa-remove fa-2x', 'url'=> $tag['id'],'disabled'=>true],
            ]);
        }
        $response->original['data'] = $registros;

        return $response->original;
    }
    public function save(Request $request){
        try{
            Tag::create($request->all());
            \Session::flash('mensagem', ['msg'=>'Tag Salva com successo', 'status'=>'sucesso']);
        }catch(\Exception $e){
            \Session::flash('mensagem', ['msg'=>'Erro ao salvar tag: '.$e->getMessage(), 'status'=>'erro']);

        }
        return redirect()->route('admin.tags');
    }

    public function update(Request $request){
        try{
            $data = $request->all();

            Tag::find($data['id'])->update($data);
            \Session::flash('mensagem', ['msg'=>'Tag Atualizada com successo', 'status'=>'sucesso']);
        }catch(\Exception $e){
            \Session::flash('mensagem', ['msg'=>'Erro ao atualizar tag: '.$e->getMessage(), 'status'=>'erro']);
        }
        return redirect()->route('admin.tags');
    }

    public function edit(Tag $tag){
        return view('admin.tag.edit', compact('tag'));

    }

    public function delete(Tag $tag){
        try{
            $tag->delete();
        }catch(\Exception $e){
            return Utilitarios::formatResponse('Erro ao excluir tag: '.$e->getMessage(), false);
        }

        return Utilitarios::formatResponse('Tag Excluida com sucesso', true);
    }

}
