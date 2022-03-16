$.validator.setDefaults({
    ignore: []
});

$(document).ready(function() {
    $('input[type=radio][name=inativo]').change(function() {
        $('#errorTxt7').hide();
        $('#radiovalidation').val('1');
    });

    $('#bairro_select').change(function() {
        $('#errorTxt2').hide();
        $('#selectorvalidation').val('1');
    })
    
    $('#formulario').validate({
        rules: {
            nome: {
                required: true,
                minlength: 5,
                maxlength: 100
            },
            selectorvalidation: {
                required: true
            },
            rua: {
                required: true,
                maxlength: 100
            },
            cep: {
                required: true,
                minlength: 9,
                maxlength: 9
            },
            numero_endereco: {
                required: true,
                maxlength: 5
            },
            complemento: {
                maxlength: 10
            },
            telefone: {
                required: true, 
                minlength: 6,
                maxlength: 16
            },
            descricao: {
                maxlength: 100
            },
            radiovalidation: "required"
        },
        errorElement : 'div',
        errorPlacement: function(error, element){
            var placement = $(element).data('error');
            if (placement){
              $(placement).append(error)
            }
            else{
              error.insertAfter(element);
            }
        },
    });
})