<input type="hidden" value="{{isset($tag) ? $tag->id : 0}}" name="id">
<div class="form-group">
    <input type="text" name="nome" required class="form-control" placeholder="" value="{{isset($tag) ? $tag->nome : ''}}" maxlength="90">
</div>

<button type="submit" class="btn btn-success mr-2">Salvar</button>
<a class="btn btn-light" href="{{route('admin.tags')}}">Cancelar</a>