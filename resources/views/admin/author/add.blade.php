@extends('admin.layout.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Adicionar Autor</h4>
                    <form class="forms-sample" action="{{route('admin.author.save')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @include('admin.author._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection