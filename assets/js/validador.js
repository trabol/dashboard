/**
*
* valida que cada vez que un  Usuario 
* se posiciona en un campo en especifico y no cumple con 
* la validacion, se levanta una alerta
**/
function validarNumero(numero){
	if($.isNumeric( numero ))
		return true;
	return false;
}

function validarRut(campo){
	if ( campo.length == 0 ){ return false; }
	if ( campo.length < 8 ){ return false; }
	 
	campo = campo.replace('-','')
	campo = campo.replace(/\./g,'')
	 
	var suma = 0;
	var caracteres = "1234567890kK";
	var contador = 0;
	for (var i=0; i < campo.length; i++){
	u = campo.substring(i, i + 1);
	if (caracteres.indexOf(u) != -1)
	contador ++;
	}
	if ( contador==0 ) { return false }
	var rut = campo.substring(0,campo.length-1)
	var drut = campo.substring( campo.length-1 )
	var dvr = '0';
	var mul = 2;
	for (i= rut.length -1 ; i >= 0; i--) {
	suma = suma + rut.charAt(i) * mul
	if (mul == 7) mul = 2
	else  mul++
	}
	res = suma % 11
	if (res==1) dvr = 'k'
	else if (res==0) dvr = '0'
	else {
	dvi = 11-res
	dvr = dvi + ""
	}
	if ( dvr != drut.toLowerCase() ) { return false; }
	else { return true; }
}
function validarNombre(nombre){
  if(nombre!=""){
    var pattern=/[a-z A-ZÃ±Ã‘Ã¡ÃÃ©Ã‰Ã­ÃÃ³Ã“ÃºÃš]$/;
    var valor=nombre;
    if(pattern.test(valor))
      return true;
    else
      return false;
  }
  return false;
}

function ValidarTelefono(telefono){

	if(telefono!=""){
		var pattern=/^[9|6|7][0-9]{8}$/;
		if(pattern.test(telefono))
			return true;
		else
			return false;
	}
  	return false;
}
function validarMail(mail){
  if(mail!=""){
    var pattern=/^[0-9a-zA-Z_\-\.]+@[.0-9a-zA-Z_\-]+?\.[a-zA-Z]{2,3}$/;
    if(pattern.test(mail))
      return true;
    else
    return false;
  }
  return false;
} 
function validarFecha(dia,mes,ano){
	if($.isNumeric(dia) && $.isNumeric(mes) && $.isNumeric(ano) ){
	    if (dia < 1 || dia > 31) {
	        return false;
	    }
	    if (mes < 1 || mes > 12) {
	        return false;
	    }
	    if(ano<1900 || ano > 2100){
	      return false;
	    }
	    if ((mes==4 || mes==6 || mes==9 || mes==11) && dia==31) {
	        return false;
	    }
	    if (mes == 2) { // bisiesto
	        var bisiesto = (ano % 4 == 0 && (ano % 100 != 0 || ano % 400 == 0));
	        if (dia > 29 || (dia==29 && !bisiesto)) {
	            return false;
	        }
	    }
	    return true;
    }
    else{
	    return false;
    }
}
function formatRut(valor) {

	$(".label-regRut").html("");
	$("#regRut").removeClass("invalido");
	var cont = 0;
	var tmp_valor = "";
	var i = 0;
	var valor2 = "";
  for (i = 0; i < valor.length; i++) {
	  if (valor.charAt(i) == "0" || valor.charAt(i) == "1" || valor.charAt(i) == "2" || valor.charAt(i) == "3" || valor.charAt(i) == "4" || valor.charAt(i) == "5" || valor.charAt(i) == "6" || valor.charAt(i) == "7" || valor.charAt(i) == "8" || valor.charAt(i) == "9" || valor.charAt(i) == "k" || valor.charAt(i) == "K") {
		  if (valor.charAt(0) != "0" && valor.charAt(0) != "k" && valor.charAt(0) != "K") {
		  	valor2 = valor2 + valor.charAt(i);
		  }
	  }
  }
  for (i = valor2.length - 1; i >= 0; i--) {
	if (cont == 1) {
	  	tmp_valor = "-" + tmp_valor;
  	}
  	// if (cont == 4) {
  	// tmp_valor = "." + tmp_valor;
  	// }
  	// if (cont == 7) {
  	// tmp_valor = "." + tmp_valor;
  	// }
  	tmp_valor = valor2.charAt(i) + tmp_valor;
  	cont++;
  }
  	return tmp_valor;
} 
function formatNumero(valor) {
    var cont = 0, tmp_valor = "", i = 0, valor2 = "";
    for (i = 0; i < valor.length; i++) {
        if (valor.charAt(i) == "0" || valor.charAt(i) == "1" || valor.charAt(i) == "2" || valor.charAt(i) == "3" || valor.charAt(i) == "4" || valor.charAt(i) == "5" || valor.charAt(i) == "6" || valor.charAt(i) == "7" || valor.charAt(i) == "8" || valor.charAt(i) == "9") {
            if (/*valor.charAt(0) != "0" &&*/ valor.charAt(0) != "k" && valor.charAt(0) != "K") {
                valor2 = valor2 + valor.charAt(i);
            }
        }
    }
    return valor2;
}
