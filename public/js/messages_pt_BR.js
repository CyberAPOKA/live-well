(function( factory ) {
	if ( typeof define === "function" && define.amd ) {
		define( ["jquery", "../jquery.validate"], factory );
	} else if (typeof module === "object" && module.exports) {
		module.exports = factory( require( "jquery" ) );
	} else {
		factory( jQuery );
	}
}(function( $ ) {

/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: PT (Portuguese; português)
 * Region: BR (Brazil)
 */
$.extend( $.validator.messages, {

	// Core
	required: "Este campo &eacute; requerido.",
	remote: "Corrija este campo.",
	email: "Forne&ccedil;a um endere&ccedil;o de email v&aacute;lido.",
	url: "Forne&ccedil;a uma URL v&aacute;lida.",
	date: "Forne&ccedil;a uma data v&aacute;lida.",
	dateISO: "Forne&ccedil;a uma data v&aacute;lida (ISO).",
	number: "Forne&ccedil;a um n&uacute;mero v&aacute;lido.",
	digits: "Forne&ccedil;a somente d&iacute;gitos.",
	creditcard: "Forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
	equalTo: "Confirmação inválida.",
	maxlength: $.validator.format( "Forne&ccedil;a n&atilde;o mais que {0} caracteres." ),
	minlength: $.validator.format( "Forne&ccedil;a ao menos {0} caracteres." ),
	rangelength: $.validator.format( "Forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento." ),
	range: $.validator.format( "Forne&ccedil;a um valor entre {0} e {1}." ),
	max: $.validator.format( "Forne&ccedil;a um valor menor ou igual a {0}." ),
	min: $.validator.format( "Forne&ccedil;a um valor maior ou igual a {0}." ),
	step: $.validator.format( "Forne&ccedil;a um valor m&acute;tiplo de {0}." ),

	// Metodos Adicionais
	maxWords: $.validator.format( "Forne&ccedil;a com {0} palavras ou menos." ),
	minWords: $.validator.format( "Forne&ccedil;a pelo menos {0} palavras." ),
	rangeWords: $.validator.format( "Forne&ccedil;a entre {0} e {1} palavras." ),
	accept: "Forne&ccedil;a um tipo v&aacute;lido.",
	alphanumeric: "Forne&ccedil;a somente com letras, n&uacute;meros e sublinhados.",
	bankaccountNL: "Forne&ccedil;a com um n&uacute;mero de conta banc&aacute;ria v&aacute;lida.",
	bankorgiroaccountNL: "Forne&ccedil;a um banco v&aacute;lido ou n&uacute;mero de conta.",
	bic: "Forne&ccedil;a um c&oacute;digo BIC v&aacute;lido.",
	cifES: "Forne&ccedil;a um c&oacute;digo CIF v&aacute;lido.",
	creditcardtypes: "Forne&ccedil;a um n&uacute;mero de cart&atilde;o de cr&eacute;dito v&aacute;lido.",
	currency: "Forne&ccedil;a uma moeda v&aacute;lida.",
	dateFA: "Forne&ccedil;a uma data correta.",
	dateITA: "Forne&ccedil;a uma data correta.",
	dateNL: "Forne&ccedil;a uma data correta.",
	extension: "Forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
	giroaccountNL: "Forne&ccedil;a um n&uacute;mero de conta corrente v&aacute;lido.",
	iban: "Forne&ccedil;a um c&oacute;digo IBAN v&aacute;lido.",
	integer: "Forne&ccedil;a um n&uacute;mero n&atilde;o decimal.",
	ipv4: "Forne&ccedil;a um IPv4 v&aacute;lido.",
	ipv6: "Forne&ccedil;a um IPv6 v&aacute;lido.",
	lettersonly: "Forne&ccedil;a apenas com letras.",
	letterswithbasicpunc: "Forne&ccedil;a apenas letras ou pontua&ccedil;ões.",
	mobileNL: "Fornece&ccedil;a um n&uacute;mero v&aacute;lido de telefone.",
	mobileUK: "Fornece&ccedil;a um n&uacute;mero v&aacute;lido de telefone.",
	nieES: "Forne&ccedil;a um NIE v&aacute;lido.",
	nifES: "Forne&ccedil;a um NIF v&aacute;lido.",
	nowhitespace: "F&atilde;o utilize espa&ccedil;os em branco.",
	pattern: "O formato fornenecido &eacute; inv&aacute;lido.",
	phoneNL: "Fornece&ccedil;a um n&uacute;mero de telefone v&aacute;lido.",
	phoneUK: "Fornece&ccedil;a um n&uacute;mero de telefone v&aacute;lido.",
	phoneUS: "Fornece&ccedil;a um n&uacute;mero de telefone v&aacute;lido.",
	phonesUK: "Fornece&ccedil;a um n&uacute;mero de telefone v&aacute;lido.",
	postalCodeCA: "Fornece&ccedil;a um n&uacute;mero de c&oacute;digo postal v&aacute;lido.",
	postalcodeIT: "Fornece&ccedil;a um n&uacute;mero de c&oacute;digo postal v&aacute;lido.",
	postalcodeNL: "Fornece&ccedil;a um n&uacute;mero de c&oacute;digo postal v&aacute;lido.",
	postcodeUK: "Fornece&ccedil;a um n&uacute;mero de c&oacute;digo postal v&aacute;lido.",
	postalcodeBR: "Forne&ccedil;a um CEP v&aacute;lido.",
	require_from_group: $.validator.format( "Forne&ccedil;a pelo menos {0} destes campos." ),
	skip_or_fill_minimum: $.validator.format( "Fptar entre ignorar esses campos ou preencher pelo menos {0} deles." ),
	stateUS: "Forne&ccedil;a um estado v&aacute;lido.",
	strippedminlength: $.validator.format( "Forne&ccedil;a pelo menos {0} caracteres." ),
	time: "Forne&ccedil;a um hor&aacute;rio v&aacute;lido, no intervado de 00:00 e 23:59.",
	time12h: "Forne&ccedil;a um hor&aacute;rio v&aacute;lido, no intervado de 01:00 e 12:59 am/pm.",
	url2: "Fornece&ccedil;a uma URL v&aacute;lida.",
	vinUS: "O n&uacute;mero de identifica&ccedil;&atilde;o de ve&iacute;culo informada (VIN) &eacute; inv&aacute;lido.",
	zipcodeUS: "Fornece&ccedil;a um c&oacute;digo postal americano v&aacute;lido.",
	ziprange: "O c&oacute;digo postal deve estar entre 902xx-xxxx e 905xx-xxxx",
	cpfBR: "Forne&ccedil;a um CPF v&aacute;lido."
} );
return $;
}));