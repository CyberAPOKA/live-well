$.validator.setDefaults({
    ignore: []
});

$(document).ready(function(){
    $("#formulario").validate({
        rules: {
            nome: {
                required: true,
                maxlength: 30
            },
            descricao: {
                required: true,
                minlength: 5,
                maxlength: 100
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
    })
});