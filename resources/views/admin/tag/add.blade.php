@extends('admin.layout.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Adicionar Tag</h4>
                    <form class="forms-sample" action="{{route('admin.tag.save')}}" method="post">
                        {{csrf_field()}}
                        @include('admin.tag._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection