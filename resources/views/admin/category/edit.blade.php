@extends('admin.layout.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Editar Categoria</h4>
                    <form class="forms-sample" action="{{route('admin.category.update')}}" method="post">
                        {{csrf_field()}}
                        @include('admin.category._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection