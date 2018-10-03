@push('style')
<link href="{{asset('/vendor/summernote/dist/summernote-bs4.css')}}" rel="stylesheet">
@endpush
<input type="hidden" value="{{isset($post) ? $post->id : 0}}" name="id">
<div class="form-group col-12">
    <img id="output_image" src="{{isset($post) ? $post->url_image : '/images/image_empty.png'}}"/>
    <input type="file" accept="image/*" onchange="preview_image(event)"  name="image" id="image">
</div>

<div class="form-group">
    <input type="text" name="title" required class="form-control" placeholder=""
           value="{{isset($post) ? $post->title : ''}}" maxlength="90"
            autofocus>
</div>

<div class="form-group col-12">
    <h1>Conteúdo do Post</h1>
    <textarea id="summernote" name="body">
        {{isset($post) ? $post->body : ''}}
    </textarea>
</div>

<button type="submit" class="btn btn-success mr-2">Salvar</button>
<a class="btn btn-light" href="{{route('admin.posts')}}">Cancelar</a>

@push('script')
{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">--}}
<script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('vendor/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/vendor/summernote/dist/summernote-bs4.js')}}"></script>

{{--<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">--}}
{{--<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>--}}
{{--<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>--}}

{{--<!-- include summernote css/js -->--}}
{{--<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">--}}
{{--<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>--}}
<script>
    $('#summernote').summernote({
        placeholder: '',
        tabsize: 2,
        height: 500
    });
</script>
@endpush