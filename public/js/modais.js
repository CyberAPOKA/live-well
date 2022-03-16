//MODAL DELETE
$(document).on('click', '#btn_delete', function(){
    if($(this).data('tipo') == 1){
        $('#tipo_delete').text('Administrador');
    }
    else{
        $('#tipo_delete').text('Professor')
    }
    $('#id_delete').val($(this).data('id'));
    $('#name_delete').text($(this).data('name'));
});

//MODAL RESTORE
$(document).on('click', '#btn-restore', function(){
    if($(this).data('tipo') == 1){
        $('#tipo_restore').text('Administrador');
    }
    else{
        $('#tipo_restore').text('Professor')
    }
    $('#id_restore').val($(this).data('id'));
    $('#name_restore').text($(this).data('name'));
});


//MODAL PESSOA E PROFESSOR
$(document).on('click', '.btn-modal_vincular', function(){
    $('#id_modal_vincular').val($(this).data('idusuario'));
    $('#id_turma_modal_vincular').val($(this).data('idturma'));
    document.getElementById('texto_id_vincular').innerHTML = 'Você deseja vincular ' + $(this).data('nomeusuario').bold() + ' em ' + $(this).data('nometurma').bold() + '?';
});

//ATIVAR E INATIVAR
$(document).on('click', '.btn-modal_ativar', function(){
    $('#id_modal_ativar').val($(this).data('idusuario'));
    $('#id_turma_modal_ativar').val($(this).data('idturma'));
    document.getElementById('texto_id_ativar').innerHTML = 'Você deseja ativar ' + $(this).data('nomeusuario').bold() + ' em ' + $(this).data('nometurma').bold() + '?';
});

$(document).on('click', '.btn-modal_inativar', function(){
    $('#id_modal_inativar').val($(this).data('idusuario'));
    $('#id_turma_modal_inativar').val($(this).data('idturma'));
    document.getElementById('texto_id_inativar').innerHTML = 'Você deseja inativar ' + $(this).data('nomeusuario').bold() + ' em ' + $(this).data('nometurma').bold() + '?';
});

//MODAL TURMA
$(document).on('click', '#btn-modal_ativar_objeto', function(){
    $('#id_modal_ativar').val($(this).data('idobjeto'));
    document.getElementById('texto_ativar').innerHTML = 'Você deseja Ativar ' + $(this).data('nomeobjeto').bold() + '?';
});

$(document).on('click', '#btn-modal_inativar_objeto', function(){
    $('#id_modal_inativar').val($(this).data('idobjeto'));
    document.getElementById('texto_inativar').innerHTML = 'Você deseja inativar ' + $(this).data('nomeobjeto').bold() + '?';
});

//MODAL DOENÇAS-ANAMNESES
function modal_doencas(doencas){
    $('#lista_de_doencas').empty();
    $('#lista_de_doencas').append('<thead><th>Nome da Doença</th><th>Descrição</th></thead>');
    for(var i = 0; i < doencas.length; i++){
        $('#lista_de_doencas').append('<tbody><tr><td>'+doencas[i].nome+'</td><td>'+doencas[i].descricao+'</td></tr></tbody>');
    }
}