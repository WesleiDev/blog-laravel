<?php

namespace App\Http\Controllers\Admin;

use App\Models\Author;
use App\Models\Post;
use App\Utilitarios;
use App\UtilitariosFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class PostController extends Controller
{
    public function index(){
        return view('admin.post.index');

    }

    public function add(){
        $authors = Author::all();
        return view('admin.post.add', compact('authors'));
    }

    public function search()
    {
        $model = Post::select(['id','title', 'comments', 'views', 'image']);


        $response = DataTables::eloquent($model)
            ->blacklist(['action'])
            ->addColumn('url_image',function($model){
                return "<img src=$model->url_image/>";
            })
            ->rawColumns(['url_image'])
            ->toJson();

        $records = $response->original['data'];
        foreach ($records as $index =>$post){
            $records[$index]['action'] = Utilitarios::getBtnAction([
                ['tipo'=> 'editar', 'nome'=> 'Editar', 'class'=> 'fa fa-edit fa-2x', 'url'=>route('admin.post.edit', [$post['id']]),'disabled'=>true],
                ['tipo'=> 'excluir', 'nome'=> 'Excluir', 'class'=> 'fa fa-remove fa-2x', 'url'=> $post['id'],'disabled'=>true],
            ]);
        }
        $response->original['data'] = $records;

        return $response->original;
    }
    public function save(Request $request){
        try{
            $data = $request->all();
            $data['category_id']= 1;
            $data['author_id']= 1;

            Post::create($data);

            \Session::flash('mensagem', ['msg'=>'Post Salvo com successo', 'status'=>'sucesso']);
        }catch(\Exception $e){
            \Session::flash('mensagem', ['msg'=>'Erro ao salvar Post: '.$e->getMessage(), 'status'=>'erro']);

        }
        return redirect()->route('admin.posts');
    }

    public function update(Request $request){
        try{
            $data = $request->all();
            $post = Post::find($data['id']);
            $post->update($data);


            \Session::flash('mensagem', ['msg'=>'Post atualizado com successo', 'status'=>'sucesso']);
        }catch(\Exception $e){
            \Session::flash('mensagem', ['msg'=>'Erro ao atualizar Post: '.$e->getMessage(), 'status'=>'erro']);
        }
        return redirect()->route('admin.posts');
    }

    public function edit(Post $post){
        return view('admin.post.edit', compact('post'));

    }

    public function delete(Post $post){
        try{
            $post->delete();
        }catch(\Exception $e){
            return Utilitarios::formatResponse('Erro ao excluir Post: '.$e->getMessage(), false);
        }

        return Utilitarios::formatResponse('Post Excluido com sucesso', true);
    }
}
