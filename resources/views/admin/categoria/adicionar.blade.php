@extends('admin.layout.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Adicionar Categoria</h4>
                    <form class="forms-sample" action="{{route('admin.categoria.salvar')}}" method="post">
                        {{csrf_field()}}
                        @include('admin.categoria._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection