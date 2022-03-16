$.validator.setDefaults({
    ignore: []
});

jQuery.validator.addMethod("fileValidation", function(value, element){
    var idade = $('#nascimentoValid').val();
    if(idade == ''){
        return false;
    }
    else{  
        if(idade > 50){
            if($('#atestado').val() == ''){
                return false
            }
            else{
                return true
            }
        }
        else{
            return true;
        }
    }
}, "Este campo é requerido.")

$(document).ready(function() {
    $("#atestado").change(function(){
        $("#atestado").delay(100);
        if($("#atestado").val != ''){
            $('#errorTxt9').hide();
        }
    });

    $('#formulario').validate({
        rules: {
            img_atestado: {
                fileValidation: true,
            },
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