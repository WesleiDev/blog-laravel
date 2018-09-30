@extends('admin.layout.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Categoria <a type="button"
                                                   class="btn btn-primary btn-fw"
                                                   href="{{route('admin.category.add')}}"
                                                    >Adicionar Categoria <i class="fa fa-plus"></i> </a></h4>
                    <table class="table table-striped" id="categoria-table">
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
        var $TABLE_CATEGORIA = null;
        $(function() {
            $TABLE_CATEGORIA =  $('#categoria-table').DataTable({
                language:{
                    "url":"/js/lang/data-table-portugues-brasil.json"
                },
                stateSave: true,
                responsive: true,
                colReorder: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.category.search') !!}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action' },
                ],
                "columnDefs": [
                    { "width": "15%", "targets": 1 }
                ]
            });
        });

        //Excluir a Categoria
        $('html').on('click', '.confirm', function(){
            var id = $(this).data('id');

            swal({
                title: 'Excluir Categoria',
                text: 'Deseja realmente excluir a Categora selecionada ?',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((confirm) => {
                if (confirm) {
                    $.ajax({
                        url: '/category/'+id,
                        method: 'delete',
                        success: function(results){
                            if(results.result){
                                $TABLE_CATEGORIA.draw()
                                swal(results.data, {
                                    icon: "success",
                                });
                            }else{
                                swal(results.data, {
                                    icon: "error",
                                });

                            }

                        }
                    })
                }
            });
        })

    </script>
@endsection