<input type="hidden" value="{{isset($autor) ? $autor->id : 0}}" name="id">
<div class="form-group col-12">
    <input type="file" accept="image/*" onchange="preview_image(event)"  name="image" id="image">
</div>
<div class="form-group col-12">
    <img id="output_image" src="{{isset($autor) ? $autor->url_image : ''}}"/>
</div>
<div class="form-group col-12 left">
    <label for="nome">Nome</label>
    <input type="text" name="nome" required class="form-control" placeholder="" value="{{isset($autor) ? $autor->nome : ''}}" maxlength="90">
</div>
<div class="form-group left">
    <button type="submit" class="btn btn-success mr-2">Salvar</button>
    <a class="btn btn-light" href="{{route('admin.autores')}}">Cancelar</a>
</div>