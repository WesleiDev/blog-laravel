<input type="hidden" value="{{isset($author) ? $author->id : 0}}" name="id">
<div class="form-group col-12">
    <img id="output_image" src="{{isset($author) ? $author->url_image : ''}}"/>
    <input type="file" accept="image/*" onchange="preview_image(event)"  name="image" id="image">
</div>
<div class="form-group col-12">

</div>
<div class="form-group col-12 left">
    <label for="nome">Nome</label>
    <input type="text" name="name" autofocus
           required class="form-control" placeholder=""
           value="{{isset($author) ? $author->name : ''}}" maxlength="90">
</div>
<div class="form-group left">
    <button type="submit" class="btn btn-success mr-2">Salvar</button>
    <a class="btn btn-light" href="{{route('admin.authors')}}">Cancelar</a>
</div>