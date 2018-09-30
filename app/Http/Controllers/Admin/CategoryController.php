<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Utilitarios;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class CategoryController extends Controller
{
    public function index(){
        return view('admin.category.index');

    }

    public function add(){
        return view('admin.category.add');
    }
    public function search()
    {

        $model = Category::select(['id','name']);

        $response = DataTables::eloquent($model)
            ->blacklist(['action'])
            ->toJson();

        $records = $response->original['data'];
        foreach ($records as $index =>$category){
            $records[$index]['action'] = Utilitarios::getBtnAction([
                ['tipo'=> 'editar', 'nome'=> 'Editar', 'class'=> 'fa fa-edit fa-2x', 'url'=>route('admin.category.edit', [$category['id']]),'disabled'=>true],
                ['tipo'=> 'excluir', 'nome'=> 'Excluir', 'class'=> 'fa fa-remove fa-2x', 'url'=> $category['id'],'disabled'=>true],
            ]);
        }
        $response->original['data'] = $records;

        return $response->original;
    }
    public function save(Request $request){
        try{
            Category::create($request->all());
            \Session::flash('mensagem', ['msg'=>'Categoria Salva com successo', 'status'=>'sucesso']);
        }catch(\Exception $e){
            \Session::flash('mensagem', ['msg'=>'Erro ao salvar Categoria: '.$e->getMessage(), 'status'=>'erro']);

        }
        return redirect()->route('admin.categories');
    }

    public function update(Request $request){
        try{
            $data = $request->all();

            Category::find($data['id'])->update($data);
            \Session::flash('mensagem', ['msg'=>'Categoria Atualizada com successo', 'status'=>'sucesso']);
        }catch(\Exception $e){
            \Session::flash('mensagem', ['msg'=>'Erro ao atualizar Categoria: '.$e->getMessage(), 'status'=>'erro']);
        }
        return redirect()->route('admin.categories');
    }

    public function edit(Category $category){
        return view('admin.category.edit', compact('category'));

    }

    public function delete(Category $category){
        try{
            $category->delete();
        }catch(\Exception $e){
            return Utilitarios::formatResponse('Erro ao excluir categoria: '.$e->getMessage(), false);
        }

        return Utilitarios::formatResponse('Categoria Excluida com sucesso', true);
    }
}
