@extends('admin.layout.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Editar Tag</h4>
                    <form class="forms-sample" action="{{route('admin.tag.atualizar')}}" method="post">
                        {{csrf_field()}}
                        @include('admin.tag._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection