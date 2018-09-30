<input type="hidden" value="{{isset($tag) ? $tag->id : 0}}" name="id">
<div class="form-group">
    <input type="text" name="name" required class="form-control" placeholder=""
           value="{{isset($tag) ? $tag->name : ''}}" maxlength="90"
            autofocus>
</div>

<button type="submit" class="btn btn-success mr-2">Salvar</button>
<a class="btn btn-light" href="{{route('admin.tags')}}">Cancelar</a>