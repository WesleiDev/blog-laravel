@extends('admin.layout.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tags <a type="button"
                                                   class="btn btn-primary btn-fw"
                                                   href="{{route('admin.tag.add')}}"
                                                    >Adicionar Tag <i class="fa fa-plus"></i> </a></h4>
                    <table class="table table-striped" id="tag-table">
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
</div>
@endsection


@section('script')
    <script>
        var $TABLE_TAG = null;
        $(function() {
             $TABLE_TAG =  $('#tag-table').DataTable({
                language:{
                    "url":"/js/lang/data-table-portugues-brasil.json"
                },
                stateSave: true,
                responsive: true,
                colReorder: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.tag.search') !!}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action' },
                ],
                "columnDefs": [
                    { "width": "15%", "targets": 1 }
                ]
            });
        });

        //Excluir a tag
        $('html').on('click', '.confirm', function(){
            var id = $(this).data('id');

            swal({
                title: 'Excluir Tag',
                text: 'Deseja realmente excluir a tag selecionada ?',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((confirm) => {
                if (confirm) {
                    $.ajax({
                        url: '/tag/'+id,
                        method: 'delete',
                        success: function(results){
                            if(results.result){
                                $TABLE_TAG.draw()
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