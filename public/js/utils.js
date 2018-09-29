$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
})


function swConfirm(titulo, msg,callback){
    swal({
        title: titulo,
        text: msg,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((confirm) => {
        if (confirm) {
        callback();
    }
});

}

//recebe o tipo da mensagem que será mostrada e a mensagem, após isso verifica qual é a mensagem e passa a função que irá montar o notify
function notify(status, mensagem, align){

    if(status == "sucesso"){
        sucesso(mensagem);
    }else if (status == "atencao"){
        atencao(mensagem);
    }else{
        erro(mensagem);
    }
}
//********A função notify no inicio do arquivo gerencia qual mensagem aparecer********esta função irá mostrar um notify de confirmção/sucesso com a mensagem passada nos parâmetros
function sucesso(mensagem){
    $.notify({
        //options
        icon: 'glyphicon glyphicon-ok',
        message: mensagem
    },{
        //settings
        type: 'success',
        z_index: 2000,
        placement: {
            align: 'center'
        }
    });
}
//********A função notify no inicio do arquivo gerencia qual mensagem aparecer********esta função irá mostrar um notify de problema/erro com a mensagem passada nos parâmetros
function erro(mensagem){
    $.notify({
        //options
        icon: 'glyphicon glyphicon-remove',
        message: mensagem
    },{
        //settings
        type: 'danger',
        z_index: 2000,
        placement: {
            align: 'center'
        }
    });
}
//********A função notify no inicio do arquivo gerencia qual mensagem aparecer******** esta função irá mostrar um notify de atenção com a mensagem passada nos parâmetros
function atencao(mensagem){
    $.notify({
        //options
        icon: 'glyphicon glyphicon-alert',
        message: mensagem
    },{
        //settings
        type: 'warning',
        z_index: 2000,
        placement: {
            align: 'center'
        }
    });
}

