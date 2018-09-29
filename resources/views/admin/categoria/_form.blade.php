<input type="hidden" value="{{isset($categoria) ? $categoria->id : 0}}" name="id">
<div class="form-group">
    <input type="text" name="nome" class="form-control" required placeholder="" value="{{isset($categoria) ? $categoria->nome : ''}}" maxlength="90">
</div>

<button type="submit" class="btn btn-success mr-2">Salvar</button>
<a class="btn btn-light" href="{{route('admin.categorias')}}">Cancelar</a>