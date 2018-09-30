<input type="hidden" value="{{isset($category) ? $category->id : 0}}" name="id">
<div class="form-group">
    <input type="text" name="name" class="form-control"
           required placeholder="" value="{{isset($category) ? $category->name : ''}}" maxlength="90"
            autofocus>
</div>

<button type="submit" class="btn btn-success mr-2">Salvar</button>
<a class="btn btn-light" href="{{route('admin.categories')}}">Cancelar</a>