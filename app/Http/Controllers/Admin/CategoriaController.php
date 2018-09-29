<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categoria;
use App\Utilitarios;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class CategoriaController extends Controller
{
    public function index(){
        return view('admin.categoria.index');

    }

    public function adicionar(){
        return view('admin.categoria.adicionar');
    }
    public function consultar()
    {

        $model = Categoria::select(['id','nome']);

        $response = DataTables::eloquent($model)
            ->blacklist(['acoes'])
            ->toJson();

        $registros = $response->original['data'];
        foreach ($registros as $index =>$categoria){
            $registros[$index]['acoes'] = Utilitarios::getBtnAction([
                ['tipo'=> 'editar', 'nome'=> 'Editar', 'class'=> 'fa fa-edit fa-2x', 'url'=>route('admin.categoria.editar', [$categoria['id']]),'disabled'=>true],
                ['tipo'=> 'excluir', 'nome'=> 'Excluir', 'class'=> 'fa fa-remove fa-2x', 'url'=> $categoria['id'],'disabled'=>true],
            ]);
        }
        $response->original['data'] = $registros;

        return $response->original;
    }
    public function salvar(Request $request){
        try{
            Categoria::create($request->all());
            \Session::flash('mensagem', ['msg'=>'Categoria Salva com successo', 'status'=>'sucesso']);
        }catch(\Exception $e){
            \Session::flash('mensagem', ['msg'=>'Erro ao salvar Categoria: '.$e->getMessage(), 'status'=>'erro']);

        }
        return redirect()->route('admin.categorias');
    }

    public function atualizar(Request $request){
        try{
            $data = $request->all();

            Categoria::find($data['id'])->update($data);
            \Session::flash('mensagem', ['msg'=>'Categoria Atualizada com successo', 'status'=>'sucesso']);
        }catch(\Exception $e){
            \Session::flash('mensagem', ['msg'=>'Erro ao atualizar Categoria: '.$e->getMessage(), 'status'=>'erro']);
        }
        return redirect()->route('admin.categorias');
    }

    public function editar(Categoria $categoria){
        return view('admin.categoria.editar', compact('categoria'));

    }

    public function delete(Categoria $categoria){
        try{
            $categoria->delete();
        }catch(\Exception $e){
            return Utilitarios::formatResponse('Erro ao excluir categoria: '.$e->getMessage(), false);
        }

        return Utilitarios::formatResponse('Categoria Excluida com sucesso', true);
    }
}
