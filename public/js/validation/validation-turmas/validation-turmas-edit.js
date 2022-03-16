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

    $('#icon_horario_inicial').change(function() {
        if(this.value == ''){
            $('#errorTxt3').show();
        }
        else{
            $('#errorTxt3').hide();
        }
    })

    $('#icon_horario_final').change(function() {

        if(this.value == ''){
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