@extends('admin.layout.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Editar Autor</h4>
                    <form class="forms-sample" action="{{route('admin.autor.atualizar')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @include('admin.autor._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection