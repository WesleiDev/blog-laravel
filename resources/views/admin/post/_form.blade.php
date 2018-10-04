@push('style')
    <link href="{{asset('/vendor/summernote/dist/summernote-bs4.css')}}" rel="stylesheet">
@endpush
<div class="row">
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-sm-9">
                <div class="form-group col-12">
                    <input type="hidden" value="{{isset($post) ? $post->id : 0}}" name="id">
                    <div class="form-group col-12">
                        <img id="output_image" src="{{isset($post) ? $post->url_image : '/images/image_empty.png'}}"/>
                        <input type="file" accept="image/*" onchange="preview_image(event)"  name="image" id="image">
                    </div>

                    <div class="form-group">
                        <label for="title">Título</label>
                        <input type="text" name="title" required class="form-control" placeholder=""
                               value="{{isset($post) ? $post->title : ''}}" maxlength="90"
                               autofocus>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-sm-9">
                <label >Author</label>
                <select name="author_id" id="author_id" class="form-control">
                    @foreach($authors as $author)
                        <option value="{{$author->id}}" {{isset($post)&& $post->author_id == $author->id ? 'selected':''}}
                                >{{$author->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-9">
                <label >Categoria</label>
                <select name="category_id" id="category_id" class="form-control">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" {{isset($post)&& $post->category_id == $category->id ? 'selected':''}}
                                >{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-9">
                <label >Tags</label>
                <select name="tags[]" id="tags" class="form-control" multiple="multiple" value="1">
                    @foreach($tags as $tag)
                        <option {{isset($post) && in_array($tag->id, $tags_post) ? 'selected': ''}}
                                value="{{$tag->id}}"> {{$tag->name}} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success mr-2">Salvar</button>
        <a class="btn btn-light" href="{{route('admin.posts')}}">Cancelar</a>
    </div>

    </div>
</div>

<div class="form-group col-12">
    <textarea id="summernote" name="body">
        {{isset($post) ? $post->body : ''}}
    </textarea>
</div>


@push('script')
{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">--}}
{{--<script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>--}}
<script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/vendor/summernote/dist/summernote-bs4.js')}}"></script>





<script>
    $('#summernote').summernote({
        placeholder: '',
        tabsize: 2,
        height: 500
    });
</script>
@endpush