@extends('admin.layout.admin')

@section('content')
<div class="content-wrapper">
        <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Posts <a type="button"
                                                   class="btn btn-primary btn-fw"
                                                   href="{{route('admin.post.add')}}"
                                                    >Adicionar Post <i class="fa fa-plus"></i> </a></h4>
                    <table class="table table-striped" id="post-table">
                        <thead>
                        <tr>
                            <th>Título</th>
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
        var $TABLE_POST = null;
        $(function() {
             $TABLE_POST =  $('#post-table').DataTable({
                language:{
                    "url":"/js/lang/data-table-portugues-brasil.json"
                },
                stateSave: true,
                responsive: true,
                colReorder: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.post.search') !!}',
                columns: [
                    { data: 'title', name: 'title' },
                    { data: 'action', name: 'action' },
                ],
                "columnDefs": [
                    { "width": "15%", "targets": 1 }
                ]
            });
        });

        //Excluir a post
        $('html').on('click', '.confirm', function(){
            var id = $(this).data('id');

            swal({
                title: 'Excluir Post',
                text: 'Deseja realmente excluir o post selecionada ?',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((confirm) => {
                if (confirm) {
                    $.ajax({
                        url: '/post/'+id,
                        method: 'delete',
                        success: function(results){
                            if(results.result){
                                $TABLE_POST.draw()
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