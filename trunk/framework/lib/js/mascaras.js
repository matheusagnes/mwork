function formataCampo(campo, Mascara, e) {
    
    var boleanoMascara;
    var key = '';
    var strCheck = '0123456789';
    var whichCode = (window.Event) ? e.keyCode :  e.which;
   
   
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    
    if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8))
        return true;
    
    if (strCheck.indexOf(key) == -1)
        return false; // Chave inválida        ;
    //var tecla = e.keyCode;

    var Digitato = e.keyCode;
    exp = /\-|\.|\/|\(|\)| /g
    campoSoNumeros = campo.value.toString().replace( exp, "" );

    var posicaoCampo = 0;
    var NovoValorCampo="";
    var TamanhoMascara = campoSoNumeros.length;

    if (Digitato != 8) { // backspace
        for(i=0; i<= TamanhoMascara; i++) {
            boleanoMascara  = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")
                || (Mascara.charAt(i) == "/"))
            boleanoMascara  = boleanoMascara || ((Mascara.charAt(i) == "(")
                || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " "))
            if (boleanoMascara) {
                NovoValorCampo += Mascara.charAt(i);
                TamanhoMascara++;
            }else {
                NovoValorCampo += campoSoNumeros.charAt(posicaoCampo);
                posicaoCampo++;
            }
        }
        campo.value = NovoValorCampo;
        return true;
    }else {
        return true;
    }
}
