@extends('admin.layout.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Adicionar Post</h4>
                    <form class="forms-sample" action="{{route('admin.post.save')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @include('admin.post._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection