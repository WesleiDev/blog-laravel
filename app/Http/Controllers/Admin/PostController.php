<?php

namespace App\Http\Controllers\Admin;

use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
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
        $authors    = Author::all();
        $categories = Category::all();
        $tags       = Tag::all();
        return view('admin.post.add', compact('authors', 'categories', 'tags'));
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

            $post = Post::create($data);
            $post->tags()->sync($data['tags']);

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
            $post->tags()->sync($data['tags']);


            \Session::flash('mensagem', ['msg'=>'Post atualizado com successo', 'status'=>'sucesso']);
        }catch(\Exception $e){
            \Session::flash('mensagem', ['msg'=>'Erro ao atualizar Post: '.$e->getMessage(), 'status'=>'erro']);
        }
        return redirect()->route('admin.posts');
    }

    public function edit(Post $post){
        $authors    = Author::all();
        $categories = Category::all();
        $tags       = Tag::all();
        $tags_post  = [];
        foreach($post->tags as $tag){
            array_push($tags_post, $tag->id);
        }

        return view('admin.post.edit', compact('post','authors', 'categories', 'tags', 'tags_post'));

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
