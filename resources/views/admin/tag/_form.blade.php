<input type="hidden" value="{{isset($tag) ? $tag->id : 0}}" name="id">
<div class="form-group">
    <input type="text" name="nome" class="form-control" placeholder="Nome da tag" value="{{isset($tag) ? $tag->nome : ''}}" maxlength="90">
</div>

<button type="submit" class="btn btn-success mr-2">Submit</button>
<a class="btn btn-light" href="{{route('admin.tags')}}">Cancel</a>