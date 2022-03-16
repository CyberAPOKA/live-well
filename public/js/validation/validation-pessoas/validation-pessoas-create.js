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

jQuery.validator.addMethod("uniqueCPFValidation", function(value, element){
    var cpf = $('#cpf').val();
    if(cpf != ''){
        var valor;
        $.ajax({
            async: false,
            type: "GET",
            url:'/cpf/ajax',
            dataType: 'json',
            data: {cpf: cpf}
        }).done(function (data){
            valor = data;
        })
        return valor;
    }
    return true;
}, "CPF já registrado no sistema.")

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
    if(rg != ''){
        var valor;
        $.ajax({
            async: false,
            type: "GET",
            url:'/rg/ajax',
            dataType: 'json',
            data: {rg: rg}
        }).done(function (data){
            valor = data;
        })
        return valor;
    }
    return true;
}, "RG já registrado no sistema.")

jQuery.validator.addMethod("ruaValidation", function(value, element){
    var valor = $('#rua').val();
    if(valor != ''){
        regex = new RegExp('^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$');
        return regex.test($('#rua').val());
    }
    else{
        return true;
    }
}, "A rua não pode ter números ou caracteres inválidos")

jQuery.validator.addMethod("paiValidation", function(value, element){
    var valor = $('#nome_do_pai').val();
    if(valor != ''){
        regex = new RegExp('^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$');
        return regex.test($('#nome_do_pai').val());
    }
    else{
        return true;
    }
}, "O nome do pai não pode ter números ou caracteres inválidos")

jQuery.validator.addMethod("maeValidation", function(value, element){
    var valor = $('#nome_da_mae').val();
    if(valor != ''){
        regex = new RegExp('^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$');
        return regex.test($('#nome_da_mae').val());
    }
    else{
        return true;
    }
}, "O nome da mãe não pode ter números ou caracteres inválidos")

jQuery.validator.addMethod("pessoaEmergenciaValidation", function(value, element){
    var valor = $('#pessoa_emergencia').val();
    if(valor != ''){
        regex = new RegExp('^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$');
        return regex.test($('#pessoa_emergencia').val());
    }
    else{
        return true;
    }
}, "O nome da mãe não pode ter números ou caracteres inválidos")

/*jQuery.validator.addMethod("fileValidation", function(value, element){
    var nascimento = $('#nascimento').val();
    if(nascimento == ''){
        return false;
    }
    else{
        var data = nascimento.split('/');
        var atual = new Date;
        var data_atual = [atual.getDate(), atual.getMonth() + 1, atual.getFullYear()]

        data[2] = +data[2];
        data[1] = +data[1];
        data[0] = +data[0];

        var idade = data_atual[2] - data[2];

        if (data_atual[1] < data[1] || data_atual[1] == data[1] && data_atual[0] < data[0]) {idade--;}
        
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
}, "Este campo é requerido.")*/

$(document).ready(function() {
    $('input[type=radio][name=sexo]').change(function() {
        $('#errorTxt1').hide();
        $('#sexovalidation').val('1');
    });

    $('input[type=radio][name=toma_medicacao]').change(function() {
        $('#errorTxt2').hide();
        $('#toma_medicacaovalidation').val('1');
    });

    $('input[type=radio][name=alergia_medicacao]').change(function() {
        $('#errorTxt3').hide();
        $('#alergia_medicacaovalidation').val('1');
    });

    $('input[type=radio][name=cirurgia]').change(function() {
        $('#errorTxt4').hide();
        $('#cirurgiavalidation').val('1');
    });

    $('input[type=radio][name=dor_ossea]').change(function() {
        $('#errorTxt5').hide();
        $('#dor_osseavalidation').val('1');
    });
    
    $('input[type=radio][name=dor_muscular]').change(function() {
        $('#errorTxt6').hide();
        $('#dor_muscularvalidation').val('1');
    });

    $('input[type=radio][name=dor_articular]').change(function() {
        $('#errorTxt7').hide();
        $('#dor_articularvalidation').val('1');
    });

    $('input[type=radio][name=fumante]').change(function() {
        $('#errorTxt8').hide();
        $('#fumantevalidation').val('1');
    });

    $("#atestado").change(function(){
        $("#atestado").delay(100);
        if($("#atestado").val != ''){
            $('#errorTxt9').hide();
        }
    });

    $('#formulario').validate({
        rules: {
            nome: {
                required: true,
                minlength: 3,
                maxlength: 50,
                nomeValidation: true
            },
            nascimento: {
                required: true,
                nascimentoValidation: true
            },
            cpf: {
                minlength: 14,
                maxlength: 14,
                uniqueCPFValidation: true,
                cpf: true
            },
            cpf_responsavel: {
                minlength: 14,
                maxlength: 14,
                cpf: true
            },
            rg: {
                minlength: 6,
                maxlength: 13,
                uniqueRGValidation: true,
            },
            rg_responsavel: {
                minlength: 6,
                maxlength: 13
            },
            rua: {
                ruaValidation: true
            },
            numero_endereco: {
                minlength: 0,
                maxlength: 15
            },
            cep: {
                minlength: 9,
                maxlength: 9
            },
            telefone:{
                minlength: 6,
                maxlength: 16
            },
            telefone_emergencia:{
                minlength: 6,
                maxlength: 16
            },
            nome_do_pai: {
                paiValidation: true
            },
            nome_da_mae: {
                maeValidation: true
            },
            pessoa_emergencia: {
                pessoaEmergenciaValidation: true
            },
            filhos: {
                minlength: 0,
                maxlength: 50
            },
            irmaos: {
                minlength: 0,
                maxlength: 50
            },
            sexovalidation: 'required',
            toma_medicacaovalidation: 'required',
            alergia_medicacaovalidation: 'required',
            cirurgiavalidation: 'required',
            dor_osseavalidation: 'required',
            dor_muscularvalidation: 'required',
            dor_articularvalidation: 'required',
            fumantevalidation: 'required',
            img_atestado: 'required',
            
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