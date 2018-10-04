@extends('admin.layout.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Autores <a type="button"
                                                   class="btn btn-primary btn-fw"
                                                   href="{{route('admin.author.add')}}"
                                                    >Adicionar Autor <i class="fa fa-plus"></i> </a></h4>
                    <table class="table table-striped" id="autor-table">
                        <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th >Ações</th>

                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
    <script>
        var $TABLE_AUTOR = null;
        $(function() {
             $TABLE_AUTOR =  $('#autor-table').DataTable({
                language:{
                    "url":"/js/lang/data-table-portugues-brasil.json"
                },
                stateSave: true,
                responsive: true,
                colReorder: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.author.search') !!}',
                columns: [
                    { data: 'url_image', name: 'url_image' },
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action' },
                ],
                "columnDefs": [
                    { "width": "15%", "targets": 2 },
                    { "width": "15%", "targets": 0 }
                ]
            });
        });

        //Excluir o autor
        $('html').on('click', '.confirm', function(){
            var id = $(this).data('id');

            swal({
                title: 'Excluir Autor',
                text: 'Deseja realmente excluir o autor selecionado ?',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((confirm) => {
                if (confirm) {
                    $.ajax({
                        url: '/author/'+id,
                        method: 'delete',
                        success: function(results){
                            if(results.result){
                                $TABLE_AUTOR.draw()
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