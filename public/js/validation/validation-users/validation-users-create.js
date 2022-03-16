$.validator.setDefaults({
    ignore: []
});

/*jQuery.validator.addMethod("uniqueEmailValidation", function(value, element){
    var email = $('#icon_email').val();
    var valor;
    $.ajax({
        async: false,
        type: "GET",
        url:'/email/ajax',
        dataType: 'json',
        data: {email: email}
    }).done(function (data){
        valor = data;
    })
    return valor;
}, "Email já regitrado no sistema.")*/

$(document).ready(function(){
    $("#formulario").validate({
        rules: {
            nick: {
                required: true,
                minlength: 5,
                maxlength: 100
            },
            email: {
                required: true,
                maxlength: 50,
                uniqueEmailValidation: true
            },
            name: {
                required: true,
                minlength: 5,
                maxlength: 30
            },
            password: {
                required: true,
                minlength: 5,
                maxlength: 30
            },
            confirm_password: {
                required: true,
                equalTo: '#password'
            }
        },
        errorElement : 'div',
        errorPlacement: function(error, element){
            var placement = $(element).data('error');
            if (placement){
              $(placement).append(error)
            }
            else{
              error.insertAfter(element)(jQuery);
            }
        },
    })
});