@extends('admin.layout.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tags <a type="button"
                                                   class="btn btn-primary btn-fw"
                                                   href="{{route('admin.tag.adicionar')}}"
                                                    >Adicionar Tag <i class="fa fa-plus"></i> </a></h4>
                    <table class="table table-striped" id="condPagto-table">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th >Ações</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(function() {
            $('#condPagto-table').DataTable({
                language:{
                    "url":"/js/lang/data-table-portugues-brasil.json"
                },
                stateSave: true,
                responsive: true,
                colReorder: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.tag.consultar') !!}',
                columns: [
                    { data: 'nome', name: 'nome' },
                    { data: 'acoes', name: 'acoes' },
                ],
                "columnDefs": [
                    { "width": "15%", "targets": 1 }
                ]
            });
        });
    </script>
@endsection