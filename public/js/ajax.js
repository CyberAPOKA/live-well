$(document).ready(function(){
    $('#botao_doenca').click(function(){
        var nome = $('#nome_doenca').val();
        var descricao = $('#descricao_doenca').val();
        $.ajax({
            type: "get",
            data: "&nome=" + nome + "&descricao=" + descricao,
            url: "/ajax/doenca",
        }).done(function (data){
            if(data == 1){
                M.toast({html: 'É necessário preencher todos os campos para cadastrar uma pessoa!'})
            }
            else{
                $('#nome_doenca').val("");
                $('#descricao_doenca').val("");
                $('#lista_de_pessoas').empty();
                for(var i = 0; i < data.length; i++){
                    $('#lista_de_pessoas').append('<option value="'+ data[i].id +'">'+ data[i].nome +'</option>');
                }
                $('select').formSelect();
                M.toast({html: 'Doença cadastrada com sucesso!'})
            }
        })
    });
});