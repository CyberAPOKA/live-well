$.validator.setDefaults({
    ignore: []
});

jQuery.validator.addMethod("nomeValidation", function(value, element){
    regex = new RegExp('^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$');
    return regex.test($('#nome').val());
}, "O nome não pode ter números ou caracteres inválidos")

jQuery.validator.addMethod("nascimentoValidation", function(value, element){
    regex = new RegExp('^[0-3][0-9]\/[0-3][0-9]\/(?:[0-9]{2})?[0-9]{2}$');
    return regex.test($('#nascimento').val());
}, "Data de nascimento inválida")

jQuery.validator.addMethod("uniqueMatriculaValidation", function(value, element){
    var matricula = $('#matricula').val();
    var id = $('#id').val();
    var valor;
    $.ajax({
        async: false,
        type: "GET",
        url:'/matricula/ajax',
        dataType: 'json',
        data: {matricula: matricula, id: id}
    }).done(function (data){
        valor = data;
    })
    return valor;
}, "Matricula já regitrado no sistema.")

jQuery.validator.addMethod("uniqueEmailValidation", function(value, element){
    var email = $('#email').val();
    var id = $('#id').val();
    var valor;
    $.ajax({
        async: false,
        type: "GET",
        url:'/email/ajax',
        dataType: 'json',
        data: {email: email, id: id, prof: true}
    }).done(function (data){
        valor = data;
    })
    return valor;
}, "Email já regitrado no sistema.")

jQuery.validator.addMethod("uniqueCPFValidation", function(value, element){
    var cpf = $('#cpf').val();
    var id = $('#id').val();
    var valor;
    $.ajax({
        async: false,
        type: "GET",
        url:'/cpf/ajax',
        dataType: 'json',
        data: {cpf: cpf, id: id, tabela: 2}
    }).done(function (data){
        valor = data;
    })
    return valor;
}, "CPF já regitrado no sistema.")

jQuery.validator.addMethod("cpf", function (value, element) {
    value = jQuery.trim(value);
    if(value != ''){
        value = value.replace('.', '');
        value = value.replace('.', '');
        cpf = value.replace('-', '');
        while (cpf.length < 11) cpf = "0" + cpf;
        var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
        var a = [];
        var b = new Number;
        var c = 11;
        for (i = 0; i < 11; i++) {
            a[i] = cpf.charAt(i);
            if (i < 9) b += (a[i] * --c);
        }
        if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11 - x }
        b = 0;
        c = 11;
        for (y = 0; y < 10; y++) b += (a[y] * c--);
        if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11 - x; }
        if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) return false;
        return true;
    }
    return true;
}, "Informe um CPF válido.");

jQuery.validator.addMethod("uniqueRGValidation", function(value, element){
    var rg = $('#rg').val();
    var id = $('#id').val();
    var valor;
    $.ajax({
        async: false,
        type: "GET",
        url:'/rg/ajax',
        dataType: 'json',
        data: {rg: rg, id: id, tabela: 2}
    }).done(function (data){
        valor = data;
    })
    return valor;
}, "RG já regitrado no sistema.")

$(document).ready(function(){
    $('#nascimento').change(function() {
        if(this.value == ''){
            $('#nascimento-error').show();
        }
        else{
            $('#nascimento-error').hide();
        }
    })

    $('#bairro_select').change(function() {
        validatadeSelectorBairro(this.value)
    })

    $('#string_bairro').keyup(function() {
        validatadeSelectorBairro(this.value)
    })

    function validatadeSelectorBairro(valor){
        if(valor != ''){
            $('#selectorbairrovalidation-error').hide();
            $('#selectorbairrovalidation').val('1');
        }
        else{
            $('#selectorbairrovalidation-error6').show();
            $('#selectorbairrovalidation').val('');
        }
    }

    $("#formulario").validate({
        rules: {
            nome: {
                required: true,
                minlength: 5,
                maxlength: 100,
                nomeValidation: true
            },
            nascimento: {
                required: true,
                nascimentoValidation: true
            },
            matricula: {
                required: true,
                uniqueMatriculaValidation: true
            },
            cidade: 'required',
            selectorbairrovalidation: 'required',
            rua: 'required',
            cep: {
                required: true,
                minlength: 9,
                maxlength: 9,
            },
            numero_endereco: {
                minlength: 0,
                maxlength: 15,
                required: true
            },
            telefone: {
                minlength: 6,
                maxlength: 16,
                required: true,
            },
            email: {
                required: true,
                uniqueEmailValidation: true
            },
            cpf: {
                required: true,
                minlength: 14,
                maxlength: 14,
                uniqueCPFValidation: true,
                cpf: true
            },
            rg: {
                required: true,
                minlength: 6,
                maxlength: 13,
                uniqueRGValidation: true
            },
            formacao: {
                minlength: 3,
                maxlength: 100,
                required: true,
            },
            curso: {
                minlength: 3,
                maxlength: 100,
                required: true,
            },
            cref: {
                required: true,
                maxlength: 255
            },
            name: 'required',
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                minlength: 5,
                required: true,
                equalTo: 'password'
            }
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