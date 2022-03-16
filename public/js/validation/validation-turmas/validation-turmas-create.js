$.validator.setDefaults({
    ignore: []
});

jQuery.validator.addMethod("timeValidationInicial", function(value, element){
    regex = new RegExp('^[0-2][0-9]:[0-5][0-9]$');
    return regex.test(document.getElementById('icon_horario_inicial').value);
}, "Tempo definido inválido")

jQuery.validator.addMethod("timeValidationFinal", function(value, element){
    regex = new RegExp('^[0-2][0-9]:[0-5][0-9]$');
    return regex.test(document.getElementById('icon_horario_final').value);
}, "Tempo definido inválido")

$(document).ready(function() {
    $('input[type=radio][name=inativo]').change(function() {
        $('#errorTxt7').hide();
        $('#radiovalidation').val('1');
    });

    $('#lista_de_dias').change(function() {
        if($("#lista_de_dias :selected").val() != null){
            $('#errorTxt5').hide();
            $('#selectordatavalidation').val('1');
        }
        else{
            $('#errorTxt5').show();
            $('#selectordatavalidation').val('');
        }
    })

    $('#lista_de_nucleos').change(function() {
        $('#errorTxt6').hide();
        $('#selectornucleosvalidation').val('1');
    })

    $('#icon_horario_inicial').change(function() {
        regex = new RegExp('^[0-2][0-9]:[0-5][0-9]$');
        if(this.value == '' || regex.test(this.value) == false){
            $('#errorTxt3').show();
        }
        else{
            $('#errorTxt3').hide();
        }
    })

    $('#icon_horario_final').change(function() {
        regex = new RegExp('^[0-2][0-9]:[0-5][0-9]$');
        if(this.value == '' || regex.test(this.value) == false){
            $('#errorTxt4').show();
        }
        else{
            $('#errorTxt4').hide();
        }
    })

    $('#formulario').validate({
        rules: {
            nome: {
                required: true,
                minlength: 5,
                maxlength: 100
            },
            limite: {
                required: true,
                number: true
            },
            horario_inicial: {
                required: true,
                timeValidationInicial: true
            },
            horario_final: {
                required: true,
                timeValidationFinal: true
            },
            selectordatavalidation: 'required',
            selectornucleosvalidation: 'required',
            radiovalidation: 'required'
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