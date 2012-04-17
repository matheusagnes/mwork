function botaoMeio(e) {
    var rightclick;
    if (!e) var e = window.event;
    if (e.which){
        if(e.which == 2)
            return true;
    }
    else if(e.button == 2){
        
        return true;
    }
    return false;
}

function mostraConteudo(id,idCont){
    $('#'+idCont).toggle('slow', function(){
        });
}

IsChildOf = function(parent, child) {
    var res = false;
    if (child != null) {
        while (child.parentNode) {
            if ((child = child.parentNode) == parent) {
                res = true;
                break;
            }
        }
    }
    return res;
};

FixOnMouseOut = function(element, event, callback) {
    var e = {
        _target: (event.toElement) ? event.toElement : event.relatedTarget
    };
    var current_mouse_target = e._target;
    if (!IsChildOf(element, current_mouse_target) && element != current_mouse_target) {
        callback.apply(this);
    }
};
           
function tamDivs(){
    var divs = document.getElementById('rolar').getElementsByTagName('div');
    var numero;
    for(var i = 0; i < divs.length; i++){
        numero = divs[i].style.height.split('px')[0];
        numero = parseInt(numero);
        tam += numero;
    }
    if(tam < tamDivRolar ){
        tamC = tam + (tamDivRolar - tam);

    }                            
}
            
            
function rolarr(){
               
    if(rolando == true){
        
        var rolar = document.getElementById('rolar');
        ii++;
            
        rolar.style.top = ii ;
        if(ii < tamC){                              
            setTimeout("rolarr()",velocidade);                    
        }else if(ii == tamC){
            ii = tam * (-1);
            setTimeout("rolarr()",velocidade);
        }
    }
}

function continuar(id){
    var div = document.getElementById(id);
    if(div.id == "externa" && rolando == false && divExterna == true){
        rolando = true;
        divExterna = false;
        rolarr();
    }
}





function selecionaCombo(valor,id){
    var select = document.getElementById(id);
    for(var i = 1; i < select.options.length; i++ ){
        if(select.options[i].value == valor){
            select.selectedIndex = i;
        }
    }                
}


function addCampoPagina(idNovas, num) 
{
    var nFotos = 0;
    var numCampo = ++countCampoPagina;

    var objNovas = document.getElementById(idNovas);

    var objDivPagina = document.createElement('div');
    objDivPagina.style.width = '350px';
    objNovas.appendChild(objDivPagina);


    var div = document.createElement('div');
    if(numCampo > 1)
    {
        nFotos = numCampo-1;
        div.innerHTML = 'Foto '+nFotos+':';
        div.style.width = '350px';
    }
    else
    {
        div.innerHTML = 'Foto Principal:';
    }

    if(nFotos < 10){                
        var objTextEspaco = document.createTextNode(' ');
        objDivPagina.appendChild(objTextEspaco);

        var objInputFile = document.createElement('input');
                
        objInputFile.type = 'file';
        if(numCampo > 1)
        {
            objInputFile.name = 'foto'+nFotos+'';
        }
        else
        {            
            objInputFile.name = 'foto0';
        }
        objDivPagina.appendChild(div);
        objDivPagina.appendChild(objInputFile);
                
        UploadFile(objInputFile).ini({
            action: 'upload.php'
        });

        if (num > 1) 
        {
            addCampoPagina(idNovas, num - 1);
        }
    }
}








function tela(){
    var script = "<script> $(function(){ $('.ui-state-default').hover( "+
    "function(){ $(this).addClass('ui-state-hover'); },"+
    "function(){ $(this).removeClass('ui-state-hover'); }"+
    ");}); </script>";

    //$.alerts._overlay('hide');
    $("BODY").append('<div id="popup_overlay"></div>');
    $("#popup_overlay").css({
        position: 'absolute',
        zIndex: 99998,
        top: '0px',
        left: '0px',
        width: '100%',
        height: $(document).height(),
        background: '#000000',
        opacity: 0.7
    });

    $("BODY").append(
        '<div  id="popup_container" style="z-index: 99999; width:auto; height:auto" >' +
        '<div class="ui-state-default ui-corner-all" id="exit">'+
        ' <span style="margin:auto; margin-top:2px;"class="ui-icon ui-icon-circle-close"> </span>'+script+' </div>'+
        '<div id="carrega"> </div>'+
        '</div>');

    var top = (($(window).height() / 2) - ($("#popup_container").outerHeight() / 2)) + (-75);
    var left = (($(window).width() / 2) - ($("#popup_container").outerWidth() / 2)) + 0;
    if( top < 0 ) top = 0;
    if( left < 0 ) left = 0;

    // IE6 fix
    if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();
    $("#popup_container").css({
        position: 'fixed',
        top: top + 'px',
        left: left + 'px'
    });

    $("#exit").click( function() {
        $("#popup_overlay").remove();
        $("#popup_container").remove();
    });



}



function telaAjax(){
    var script = "<script> $(function(){ $('.ui-state-default').hover( "+
    "function(){ $(this).addClass('ui-state-hover'); },"+
    "function(){ $(this).removeClass('ui-state-hover'); }"+
    ");}); </script>";

    //$.alerts._overlay('hide');
    $("BODY").append('<div id="popup_overlay_ajax"></div>');
    $("#popup_overlay_ajax").css({
        position: 'absolute',
        zIndex: 99998,
        top: '0px',
        left: '0px',
        width: '100%',
        height: $(document).height(),
        background: '#000000',
        opacity: 0.7
    });

    $("BODY").append(
        '<div  id="popup_container_ajax" style="z-index: 99999; width:250px; height:auto" >' +
        '<div class="ui-state-default ui-corner-all" id="exit_ajax">'+
        ' <span style="margin:auto; margin-top:2px;"class="ui-icon ui-icon-circle-close"> </span>'+script+' </div>'+
        '<div id="carrega"> </div>'+
        '</div>');

    var top = (($(window).height() / 2) - ($("#popup_container_ajax").outerHeight() / 2)) + (-75);
    var left = (($(window).width() / 2) - ($("#popup_container_ajax").outerWidth() / 2)) + 0;
    if( top < 0 ) top = 0;
    if( left < 0 ) left = 0;

    // IE6 fix
    if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();
    $("#popup_container_ajax").css({
        position: 'fixed',
        top: top + 'px',
        left: left + 'px'
    });

    $("#exit_ajax").click( function() {
        $("#popup_overlay_ajax").remove();
        $("#popup_container_ajax").remove();
    });
}

function telaExportar(){
    var script = "<script> $(function(){ $('.ui-state-default').hover( "+
    "function(){ $(this).addClass('ui-state-hover'); },"+
    "function(){ $(this).removeClass('ui-state-hover'); }"+
    ");}); </script>";

    //$.alerts._overlay('hide');
    $("BODY").append('<div id="popup_overlay_exportar"></div>');
    $("#popup_overlay_exportar").css({
        position: 'absolute',
        zIndex: 99998,
        top: '0px',
        left: '0px',
        width: '100%',
        height: $(document).height(),
        background: '#000000',
        opacity: 0.7
    });

    $("BODY").append(
        '<div  id="popup_exportar" style="z-index: 99999; width:450px; height:390px;" >' +
        '<h1 id="popup_title_exportar"> <div class="ui-state-default ui-corner-all" id="exit_exportar">'+
        ' <span style="margin:auto; margin-top:2px;"class="ui-icon ui-icon-circle-close"> </span>'+script+' </div> </h1> '+
        '<div id = "popup_content_exportar" > <div id="divExportar"> </div> </div>'+
        '</div>');

    var top = (($(window).height() / 2) - ($("#popup_exportar").outerHeight() / 2)) + (-75);
    var left = (($(window).width() / 2) - ($("#popup_exportar").outerWidth() / 2)) + 0;
    if( top < 0 ) top = 0;
    if( left < 0 ) left = 0;

    // IE6 fix
    if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();
    $("#popup_exportar").css({
        position: 'fixed',
        top: top + 'px',
        left: left + 'px'
    });

    $("#exit_exportar").click( function() {
        $("#popup_overlay_exportar").remove();
        $("#popup_exportar").remove();
    });
}


function telaMail(){
    var script = "<script> $(function(){ $('.ui-state-default').hover( "+
    "function(){ $(this).addClass('ui-state-hover'); },"+
    "function(){ $(this).removeClass('ui-state-hover'); }"+
    ");}); </script>";

    //$.alerts._overlay('hide');
    $("BODY").append('<div id="popup_overlay_mail"></div>');
    $("#popup_overlay_mail").css({
        position: 'absolute',
        zIndex: 99998,
        top: '0px',
        left: '0px',
        width: '100%',
        height: $(document).height(),
        background: '#000000',
        opacity: 0.7
    });

    $("BODY").append(
        '<div  id="popup_mail" style="z-index: 99999; width:450px; height:390px;" >' +
        '<h1 id="popup_title_mail">Envie uma Proposta ao vendedor <div class="ui-state-default ui-corner-all" id="exit_mail">'+
        ' <span style="margin:auto; margin-top:2px;"class="ui-icon ui-icon-circle-close"> </span>'+script+' </div> </h1> '+
        '<div id = "popup_content_mail" > <div id="divMail"> </div> </div>'+
        '</div>');

    var top = (($(window).height() / 2) - ($("#popup_mail").outerHeight() / 2)) + (-75);
    var left = (($(window).width() / 2) - ($("#popup_mail").outerWidth() / 2)) + 0;
    if( top < 0 ) top = 0;
    if( left < 0 ) left = 0;

    // IE6 fix
    if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();
    $("#popup_mail").css({
        position: 'fixed',
        top: top + 'px',
        left: left + 'px'
    });

    $("#exit_mail").click( function() {
        $("#popup_overlay_mail").remove();
        $("#popup_mail").remove();
    });
}





function entra(e){
    if(e.KeyCode == '13'){
        document.getElementById('okLogin');
    }
    

}

function writeInput(element, text){
    if(element.value == ""){
        element.value = text;
    }
}


function clearInput(element, text){
    if(element.value == text){
        element.value = "";
    }
} 


//function ocultar(){
//    document.getElementById('right').style.display = '';
//    document.getElementById('conteudo').style.width = '550px';
//}

/*Função Pai de Mascaras*/
function mascara(o,f){
    v_obj=o;
    v_fun=eval(f);
    setTimeout("execmascara()",1)
}

/*Função que Executa os objetos*/
function execmascara(){
    v_obj.value=v_fun(v_obj.value);
}

function alertaR(texto,titulo,url,div){

    jAlertR(texto,titulo,url,div);
    
}

function moedaMilhar(v) {
    v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
    //v=v.replace(/^([0-9]{3}\.?){3}-[0-9]{2}$/,"$1.$2");
    v=v.replace(/(\d)(\d{5})$/,"$1.$2") //Coloca virgula antes dos 5 últimos digitos
    v=v.replace(/(\d)(\d{2})$/,"$1,$2") //Coloca ponto antes dos 2 últimos digitos
    return v
}



function muda(id,nome){
    var foto = document.getElementById(id);
    foto.src = nome;
   
}


function fazDivEmail(){
    var email = "<div id='conteudoEmail'> </div>";
    return email;
}

function fazTitulo(){
    var titulo = "Envie uma proposta ao vendedor ";
    return titulo;
}

function maisFotos(cont){
    
    document.getElementById('foto'+cont).style.display = '';
    
}

function limpaBox(id){
    document.getElementById(id).innerHTML = "<select name='modeloId' style='width:190px;font-size:11px;'> <option> Selecione </option> </select>";
}


function mostraForm(id){
    var div = document.getElementById(id);   
    if(div.style.display == 'none'){
        div.style.display = '';
    }else{
        div.style.display = 'none';
    }
}

function formataData(campo,teclapres) {
    var tecla = teclapres.keyCode;
    var vr = document.getElementById(campo).value;
    //alert(campo);
    vr = vr.replace( ".", "" );
    vr = vr.replace( "/", "" );
    vr = vr.replace( "/", "" );
    vr = vr.replace( "/", "" );
    var tam = vr.length + 1;

    if ( tecla != 9 && tecla != 8 ){
        if ( tam > 2 && tam < 5 ){
            document.getElementById(campo).value = vr.substr( 0, tam - 2  ) + '/' + vr.substr( tam - 2, tam );
        }
        if ( tam >= 5 && tam <= 10){

            document.getElementById(campo).value = vr.substr( 0, 2 ) + '/' + vr.substr( 2, 2 ) + '/' + vr.substr( 4, 4 );
            if ( tam >= 7 && tam <= 10 ){

        }
        }
    }
}

function formataHora(campo,teclapres) {
    var tecla = teclapres.keyCode;
    vr = document.getElementById(campo).value;
    //alert(campo);
    vr = vr.replace( ".", "" );
    vr = vr.replace( ":", "" );
    vr = vr.replace( ":", "" );
    vr = vr.replace( ":", "" );
    tam = vr.length + 1;

    if ( tecla != 9 && tecla != 8 ){
        if ( tam > 2 && tam < 5 ){
            document.getElementById(campo).value = vr.substr( 0, tam - 2  ) + ':' + vr.substr( tam - 2, tam );
        }
        if ( tam >= 5 && tam <= 10 ){

            document.getElementById(campo).value = vr.substr( 0, 2 ) + ':' + vr.substr( 2, 2 ) + ':' + vr.substr( 4, 4 );
            if ( tam >= 7 && tam <= 10 ){
        //alert(document.cadastro[campo].value + vr);
        }
        }
    }
}

function abreElemento(id){
    document.getElementById(id).style.display = "";
//document.getElementById(link).setAttribute("href", "javascript:fechaElemento('"+id+"', '"+link+"')");
}

function fechaElemento(id){
    document.getElementById(id).style.display = "none";
//document.getElementById(link).setAttribute("href", "javascript:abreElemento('"+id+"', '"+link+"')");
}

function teste(id){
    var elementoId = document.getElementById(id);
    if(elementoId.style.display == "none"){
        elementoId.style.display = "";
    }else{
        elementoId.style.display = "none";
    }
}

function abrirModulo(id){
    var moduloToOpen = document.getElementById(id);
    var modulos = document.getElementById('modulos_box');

    if(moduloToOpen){
        for(var i in modulos.childNodes){
            if (
                modulos.childNodes[i].nodeName == "DIV" &&
                modulos.childNodes[i].className =="modulo"
                ) {
                modulos.childNodes[i].style.display = 'none';
            }
        }
        moduloToOpen.style.display = '';
    }
}

function fecharModulo(id){
    if(document.getElementById(id)){
        document.getElementById(id).style.display = 'none';
    }
}



function abrirSubMenu(idSubMenu, idLink){
    var submenu = document.getElementById(idSubMenu);
    var link = document.getElementById(idLink);

    if(submenu){
        submenu.style.display = '';
        if(link){
            link.style.backgroundColor = '#1c4c7e';
            link.style.backgroundImage = 'url(imgs/bt_menu.jpg)';
            link.style.color = '#ffffff';
        }
    }
}

function fecharSubMenu(idSubMenu, idLink){
    var submenu = document.getElementById(idSubMenu);
    var link = document.getElementById(idLink);

    if(submenu){
        submenu.style.display = 'none';
        if(link){
            link.style.backgroundColor = '';
            link.style.backgroundImage = '';
            link.style.color = '';
        }
    }
}



function teste2(id, texto1, texto2){
    var elementoId = document.getElementById(id);
    if(elementoId.childNodes[0].nodeValue == texto1){
        elementoId.childNodes[0].nodeValue = texto2;
    } else {
        elementoId.childNodes[0].nodeValue = texto1;
    }
}
function teste3(id, img1, img2){
    var elementoId = document.getElementById(id);
    if(elementoId.src == img1 || elementoId.src.indexOf(img1) > -1){
        elementoId.src = img2;
    } else {
        elementoId.src = img1;
    }
}

function limparAllInputs(){
    for (var i1 = 0; i1 < document.forms.length; i1++) {
        for (var i2 = 0; i2 < document.forms[i1].elements.length; i2++) {
            var input = document.forms[i1].elements[i2];

            //if(input.type != 'submit' && input.type != 'buttom' && input.type != 'hidden'){
            if(input.type == 'text'){
                input.value = '';
            }
            if(input.type == 'select-one'){
                input.selectedIndex = 0;
            /*for (var i3 = 0; i3 < input.options.length; i3++) {
                    input.options[i3].selected = false;
                }*/
            }
        }
    }
}

function checar_formulario(form1){

    if (form1.nome.value == ""){
        alert("Por favor, informe seu nome!");
        form1.nome.focus();
        return (false);
    }


    if (form1.email.value.search(/^\w+((-\w+)|(\.\w+))*\@\w+((\.|-)\w+)*\.\w+$/) == -1) {
        alert("Seu endereço de e-mail parece estar incorreto. \nPor favor, verifique se não está faltando '@', '.' e/ou dominio.");
        form1.email.focus();
        form1.email.select();
        return false;
    }

    return true;
}

function check(browser)
{

    document.getElementById('answer').value=atualiza();
}
function atualiza()
{
    var todos = document.getElementById('todostipos').value;
    var cadaum = todos.split('-');
    var total = new Number(0);

    var selection = null;

    for(i=0;i<document.getElementById('simulacao').elements.length;i++)
    {
        if(document.getElementById('simulacao').elements[i].type == 'radio') {
            if(document.getElementById('simulacao').elements[i].checked) {
                //  selection = document.getElementById('simulacao').elements[i].value;
                lcada = document.getElementById('simulacao').elements[i].value.split('-');
                total = total + parseFloat(lcada[2]);
            }
        }
    }

    return total;
}


function janela(str)
{
    window.open(str,'janela','toolbar=no,width=800,height=620,scrollbars=no,resizable=no');
}

function abreJanela(arquivo, tamx, tamy)
{
    // onde arquivo é html popUp, tamx é o tamanho horizontal em pixels e tamy tamanho vertical em pixels
    window.open(arquivo,"","resizable=yes,toolbar=no,status=no,menubar=no,scrollbars=yes,width=" + tamx + ",height=" + tamy)
}



function validaCpf(campo) {
    var cpf = campo.value;
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    digitos_iguais = 1;

    cpf = cpf.replace(/\D/g, '');

    if (cpf.length != 11) {
        campo.style.backgroundColor = '#fd6c83';
        jAlert("Por favor insira um CPF válido !!", "ATENÇÃO");
        return false;
    }
    for (i = 0; i < cpf.length - 1; i++) {
        if (cpf.charAt(i) != cpf.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    }
    if (!digitos_iguais) {
        numeros = cpf.substring(0,9);
        digitos = cpf.substring(9);
        soma = 0;
        for (i = 10; i > 1; i--) {
            soma += numeros.charAt(10 - i) * i;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0)) {
            campo.style.backgroundColor = '#fd6c83';
            jAlert("Por favor insira um CPF válido !!", "ATENÇÃO");
            return false;
        }
        numeros = cpf.substring(0,10);
        soma = 0;
        for (i = 11; i > 1; i--) {
            soma += numeros.charAt(11 - i) * i;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1)) {
            campo.style.backgroundColor = '#fd6c83';
            jAlert("Por favor insira um CPF válido !!", "ATENÇÃO");
            return false;
        }
        campo.style.backgroundColor = '#a4ffbe';
        return true;
    } else {
        campo.style.backgroundColor = '#fd6c83';
        jAlert("Por favor insira um CPF válido !!", "ATENÇÃO");
        return false;
    }
}
function validaCnpj(campo) {
    var cnpj = campo.value;
 



    var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
    digitos_iguais = 1;

    cnpj = cnpj.replace(/\D/g, '');    
    if (cnpj.length != 14) {
        campo.style.backgroundColor = '#fd6c83';
        jAlert("Por favor insira um CNPJ válido !!", "ATENÇÃO");
        return false;
    }
    for (i = 0; i < cnpj.length - 1; i++) {
        if (cnpj.charAt(i) != cnpj.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    }
    if (!digitos_iguais) {
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) {
                pos = 9;
            }
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0)) {
            campo.style.backgroundColor = '#fd6c83';
            jAlert("Por favor insira um CNPJ válido !!", "ATENÇÃO");
            return false;
        }
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) {
                pos = 9;
            }
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1)) {
            campo.style.backgroundColor = '#fd6c83';
            jAlert("Por favor insira um CNPJ válido !!", "ATENÇÃO");
            return false;
        }
        campo.style.backgroundColor = '#a4ffbe';
        return true;
    } else {
        campo.style.backgroundColor = '#fd6c83';
        jAlert("Por favor insira um CNPJ válido !!", "ATENÇÃO");
        return false;
    }
}
function valida_rg(rg) {
    rg = rg.replace(/\D/g, '');
    if(!/^\d{10}$/.test(rg)) {
        return false;
    }
    return true;
}
function valida_cep(cep) {
    cep = cep.replace(/\D/g, '');
    if(!/^\d{8}$/.test(cep)) {
        return false;
    }
    return true;
}

// Limpa campos zerados
function limpaCampoZero(campo) {
    //var tecla = teclapres.keyCode;
    vr = document.getElementById(campo).value;
    if(vr==0){
        document.getElementById(campo).value = '';
    }

}

// Seta cursor no fim do texto para o IE 6 e 7.
// Resolve problema de desordenação dos números na validação.
function setCursorAtEnd(oTextbox) {
    if (oTextbox .createTextRange) {
        var r = (oTextbox.createTextRange());
        r.moveStart('character', (oTextbox.value.length));
        r.collapse();
        r.select();
    }
}

function formataFloat(campo,teclapres) {
    var tecla = teclapres.keyCode;
    vr = document.getElementById(campo).value;
    //alert(campo);
    vr = vr.replace( " ", "" );
    // Tabela asci
    vr = vr.replace(/[:-~]/,'');
    vr = vr.replace( ",", "." );
    vr = vr.replace(/[!--]/,'');

    document.getElementById(campo).value = vr;

}

// Exclui linha do orçamento
function excluiLinha(campo) {
    //var tecla = teclapres.keyCode;
    document.getElementById('itemExcluir').value = campo;
    document.getElementById('produtoId').value = "0";
// fechaElemento(campo);
// document.forms[0].submit();

}







function novoAjax(){
    if (typeof XMLHttpRequest != "undefined") //verifica se o browser suporta XMLHttpRequest
        return new XMLHttpRequest();
    else if (typeof ActiveXObject != "undefined") { // suporte ao IE 7
        var aVersoes = ["MSXML2.XMLHttp.6.0", "MSXML2.XMLHttp.5.0",
        "MSXML2.XMLHttp.4.0", "MSXML2.XMLHttp.3.0",
        "MSXML2.XMLHttp", "Microsoft.XMLHttp"];
        for (var i = 0; i < aVersoes.length; i++){
            try{
                return new ActiveXObject(aVersoes[i]);
            }catch (e) {}
        }
    }
    // retorna erro se nenhum tipo de objeto AJAX é suportado.
    //Tem que se ver se aqui não é necessário um código para usuar post normal
    throw new Error("Seu browser nao suporta AJAX");

}


//Formata os dados para formato da variável $_POST
function criaReqStr(oForm){
    var aPostStr = new Array();
    var document = document.getElementById(oForm);

    for(var i = 0; i < document.elements.length; i++){
        var sValor = encodeURIComponent(document.elements[i].name);

        sValor += "=";
        sValor += encodeURIComponent(document.elements[i].value);

        aPostStr.push(sValor);

    }

    return aPostStr.join("&");
}


///////////////////////



function fazSomaLinha(vlUnitId, qtId, idDestino ){

    resultado = document.getElementById(vlUnitId).value * document.getElementById(qtId).value;
    document.getElementById(idDestino).value = resultado.toFixed(2);
    return true;
}

function somaTotais(produtoIdTodos, destinoId){

    prodId = document.getElementById(produtoIdTodos).value
    prodId = prodId.split(",");
    x = prodId.length;
    total = 0;

    for(i = 0; i < x; i++){
        total = (total * 1) + (document.getElementById(prodId[i]+'_soma').value * 1);
    }
    document.getElementById(destinoId).value = total;
    document.getElementById(destinoId+'_d').value = total;

}
function formataMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    // 13=enter, 8=backspace as demais retornam 0(zero)
    // whichCode==0 faz com que seja possivel usar todas as teclas como delete, setas, etc
    if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8))
        return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave

    if (strCheck.indexOf(key) == -1)
        return false; // Chave inválida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal))
            break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1)
            aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0)
        objTextBox.value = '';
    if (len == 1)
        objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2)
        objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
            objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
//onKeyPress=?return(formataMoeda(this,?.',?,',event))?;
}
function comparaValor(total){
    var valor = document.pagar.valor.value;
    var t;
    t = valor.replace(".","");
    t = t.replace(",",".");
    var parcela = parseFloat(t);
    if(parcela > total){
        alert("Valor a ser pago deve ser menor que o valor da parcela!");
        return false;
    }


}

function taVazio(){

    for (i=0;i<document.forms['oForm'].elements.length;i++){
        if(document.forms['oForm'].elements[i].value.match(/^\s*$/) && document.forms['oForm'].elements[i].type != 'hidden'){
            alert('Por favor, preencha todos os campos!');
            document.forms[0].elements[i].focus();
            return false;
        }
    }
    return true;
}

function mudancaEstado(){
    var ajax = novoAjax();
    if (ajax.readyState == 4){
        document.getElementById("conteudo").innerHTML = ajax.responseText;
    }
}

//function blabla(pagina,id){
//    var ajax = novoAjax();
//    var url = pagina;
//    ajax.onreadystatechange = document.getElementById("conteudo").innerHTML = ajax.responseText;
//    ajax.open("GET",url,true);
//
//    ajax.send(null);
//    if (ajax.readyState == 1) {
//        document.getElementById(id).innerHTML = "<img src='loader.gif'>";
//
//    }
//    return url;
//}

function extraiScript(texto){
    var ini, pos_src, fim, codigo;
    var objScript = null;
    ini = texto.indexOf('<script', 0)
    while (ini!=-1){
        var objScript = document.createElement("script");
        //Busca se tem algum src a partir do inicio do script
        pos_src = texto.indexOf(' src', ini)
        ini = texto.indexOf('>', ini) + 1;

        //Verifica se este e um bloco de script ou include para um arquivo de scripts
        if (pos_src < ini && pos_src >=0){//Se encontrou um "src" dentro da tag script, esta e um include de um arquivo script
            //Marca como sendo o inicio do nome do arquivo para depois do src
            ini = pos_src + 4;
            //Procura pelo ponto do nome da extencao do arquivo e marca para depois dele
            fim = texto.indexOf('.', ini)+4;
            //Pega o nome do arquivo
            codigo = texto.substring(ini,fim);
            //Elimina do nome do arquivo os caracteres que possam ter sido pegos por engano
            codigo = codigo.replace("=","").replace(" ","").replace("\"","").replace("\"","").replace("\'","").replace("\'","").replace(">","");
            // Adiciona o arquivo de script ao objeto que sera adicionado ao documento
            objScript.src = codigo;
        }else{//Se nao encontrou um "src" dentro da tag script, esta e um bloco de codigo script
            // Procura o final do script
            fim = texto.indexOf('</script>', ini);
            // Extrai apenas o script
            codigo = texto.substring(ini,fim);
            // Adiciona o bloco de script ao objeto que sera adicionado ao documento
            objScript.text = codigo;
        }

        //Adiciona o script ao documento
        document.body.appendChild(objScript);
        // Procura a proxima tag de <script
        ini = texto.indexOf('<script', fim);

        //Limpa o objeto de script
        objScript = null;
    }
}




function BuscaElementosForm(idForm) {
    var elementosFormulario = document.getElementById(idForm).elements;
    var qtdElementos = elementosFormulario.length;
    var queryString = "";
    var elemento;
    this.ConcatenaElemento = function(nome,valor) {
        if (queryString.length>0) {
            queryString += "&";
        }
        queryString += encodeURIComponent(nome) + "=" + encodeURIComponent(valor);
    };
    for (var i=0; i<qtdElementos; i++) {
        elemento = elementosFormulario[i];
        if (!elemento.disabled) {
            switch(elemento.type) {
                case 'text': case 'password': case 'hidden': case 'textarea': case 'file':
                    this.ConcatenaElemento(elemento.name,elemento.value);
                    break;
                case 'select-one':
                    if (elemento.selectedIndex>=0) {
                        this.ConcatenaElemento(elemento.name,elemento.options[elemento.selectedIndex].value);
                    }
                    break;
                case 'select-multiple':
                    for (var j=0; j<elemento.options.length; j++) {
                        if (elemento.options[j].selected) {
                            this.ConcatenaElemento(elemento.name,elemento.options[j].value);
                        }
                    }
                    break;
                case 'checkbox': case 'radio':
                    if (elemento.checked) {
                        this.ConcatenaElemento(elemento.name,elemento.value);
                    }
                    break;
            }
        }
    }
    return queryString;
}


function fazGet(idForm) {
    var elementosFormulario = document.getElementById(idForm).elements;
    var qtdElementos = elementosFormulario.length;
    var queryString = "";
    var elemento;
    var checks;
    this.ConcatenaElemento = function(nome,valor) {
        if (queryString.length>0) {
            queryString += "&";
        }
        queryString += encodeURIComponent(nome) + "=" + (valor);
    };
    for (var i=0; i<qtdElementos; i++) {
        elemento = elementosFormulario[i];
        if (!elemento.disabled) {
            switch(elemento.type) {
                case 'text': case 'password': case 'hidden': case 'textarea': case 'file':
                    this.ConcatenaElemento(elemento.name,elemento.value);
                    break;
                case 'select-one':
                    if (elemento.selectedIndex>=0) {
                        this.ConcatenaElemento(elemento.name,elemento.options[elemento.selectedIndex].value);
                    }
                    break;
                case 'select-multiple':
                    for (var j=0; j<elemento.options.length; j++) {
                        if (elemento.options[j].selected) {
                            this.ConcatenaElemento(elemento.name,elemento.options[j].value);
                        }
                    }
                    break;
                case 'checkbox': case 'radio':
                    if (elemento.checked) {
                        //checks += "_"+elemento.value+"" ;
                        
                        this.ConcatenaElemento(elemento.name,elemento.value);
                    }
                    break;
            }
        }
    }
    return queryString;
}



function fazPost(id){
    //var form = document.forms[id];

    

    var elements = document.getElementById(id);
    var fields = null;
    //for (var i = 0; i < elements.length; i++) {
    if ((name = elements.name) && (value = elements.value)){
        //if(i == 0){
        fields = name + "=" + encodeURIComponent(value);
    //} else {
    //  fields += "&"+(name + "=" + encodeURIComponent(value));
    //}
    //}
    }
    //}
    //alert (fields);
    return fields;
}

function request(url, tipo)
{
    var ajax = novoAjax();

    if(ajax != null)
    {                
        var cache = new Date().getTime();
        
        ajax.open(tipo, url + "&cache=" + cache , true);
        ajax.onreadystatechange = function status()
        {
            if(ajax.readyState == 4)
            {
                if(ajax.status == 200)
                {
                    
                }
            }
        }
            

    }

    if(tipo == "POST"){
            
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
        ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
        ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
        ajax.setRequestHeader("Pragma", "no-cache");
        ajax.send(campos);
    }
    else {
        ajax.send(null);
    }
}




function requestPage(url, div, tipo, campos,store)
{
    var ajax = novoAjax();

    if(ajax != null)
    {
        
        if(store){
            bookmarks.sethash(store,url,div);
        }
        var cache = new Date().getTime();
        telaAjax();
        var divCarrega = "carrega";
        ajax.open(tipo, url + "&cache=" + cache , true);
        ajax.onreadystatechange = function status()
        {
            if(ajax.readyState == 4)
            {
                if(ajax.status == 200)
                {
                    document.getElementById(div).innerHTML = ajax.responseText;
                    var texto=unescape(ajax.responseText);
                    extraiScript(texto);                    
                                          
                    $("#popup_container_ajax").remove();                    
                    $("#popup_overlay_ajax").remove();
                    $(window).unbind('resize');
                    
                }
            }
            else if(ajax.readyState == 0)
                document.getElementById(divCarrega).innerHTML = '<div style="text-align: center;"><img src="lib/css/images/load.gif" /></div>';
            else if(ajax.readyState == 3)
                document.getElementById(divCarrega).innerHTML = '<div style="text-align: center;"><img src="lib/css/images/load.gif" /></div>';
            else
                document.getElementById(divCarrega).innerHTML = '<div style="text-align: center;"><img src="lib/css/images/load.gif" /></div>';

        }

        if(tipo == "POST"){
            
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
            ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
            ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
            ajax.setRequestHeader("Pragma", "no-cache");
            ajax.send(campos);
        }
        else {
            ajax.send(null);
        }
    }

}

function requestPage1(url, tipo, campos)
{
    var ajax = novoAjax();

    if(ajax != null)
    {


        var cache = new Date().getTime();
        ajax.open(tipo, url + "&cache=" + cache , true);
        ajax.onreadystatechange = function status()
        {
            
            
            if(ajax.status == 200)
            {
                    
                var texto=unescape(ajax.responseText);
                extraiScript(texto);
            }
            
        }

        if(tipo == "POST"){
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
            ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
            ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
            ajax.setRequestHeader("Pragma", "no-cache");
            ajax.send(campos);
        }
        else {
            ajax.send(null);
        }
    }

    

}



function mudaHora(){
    var date = new Date();
    var hora = date.getHours();
    var min = date.getMinutes();
    var seg = date.getSeconds();
}



function Redireciona(tempo,url,onde,msg)
{
    var NovaMsg = msg.replace('!tempo',tempo);
    document.getElementById(onde).innerHTML = NovaMsg;
    tempo--;
    if(tempo == -1){
        location.href = url;
    }
    else{
        var nr = 'setTimeout("Redireciona('+tempo+',\''+url+'\',\''+onde+'\',\''+msg+'\')",1000)';
        
        eval(nr);
    }
}


function formataCpf(campo,e){
    var key = '';
    var strCheck = '0123456789';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8))
        return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1)
        return false; // Chave inválida        ;
    //var tecla = e.keyCode;
    vr = document.getElementById(campo).value;
    var tam = vr.length + 1;
    if(tam == 4){
        document.getElementById(campo).value = vr.substr( 0, tam ) + '.' + vr.substr( tam , tam );
    }
    if(tam == 8){
        document.getElementById(campo).value = vr.substr( 0, tam ) + '.' + vr.substr( tam , tam );
    }
    if(tam == 12){
        document.getElementById(campo).value = vr.substr( 0, tam ) + '-' + vr.substr( tam , tam );
    }
//input type="text" id="cpf" value="" maxlength="14" onkeypress="return(formataCpf('cpf', event))"/>
}
//##.###.###/####-##

function formataCnpj(campo,e){
    var key = '';
    var strCheck = '0123456789';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8))
        return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1)
        return false; // Chave inválida        ;
    //var tecla = e.keyCode;
    vr = document.getElementById(campo).value;
    var tam = vr.length;
    if(tam == 2){
        document.getElementById(campo).value = vr.substr( 0, tam ) + '.' + vr.substr( tam , tam );
    }
    if(tam == 6){
        document.getElementById(campo).value = vr.substr( 0, tam ) + '.' + vr.substr( tam , tam );
    }
    if(tam == 10){
        document.getElementById(campo).value = vr.substr( 0, tam ) + '/' + vr.substr( tam , tam );
    }
    if(tam == 15){
        document.getElementById(campo).value = vr.substr( 0, tam ) + '-' + vr.substr( tam , tam );
    }
//input type="text" id="cpf" value="" maxlength="14" onkeypress="return(formataCpf('cpf', event))"/>
}


function formataTel(campo,e){
    var key = '';
    var strCheck = '0123456789';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8))
        return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1)
        return false; // Chave inválida        ;
    //var tecla = e.keyCode;
    vr = document.getElementById(campo).value;
    var tam = vr.length;
    if(tam == 0){
        document.getElementById(campo).value = vr.substr( 0, tam ) + '(' + vr.substr( tam , tam );
    }
    if(tam == 3){
        document.getElementById(campo).value = vr.substr( 0, tam ) + ')' + vr.substr( tam , tam );
    }
    if(tam == 8){
        document.getElementById(campo).value = vr.substr( 0, tam ) + '-' + vr.substr( tam , tam );
    }
//input type="text" id="cpf" value="" maxlength="14" onkeypress="return(formataCpf('cpf', event))"/>
}

function formataCep(campo,e){
    var key = '';
    var strCheck = '0123456789';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8))
        return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1)
        return false; // Chave inválida        ;
    //var tecla = e.keyCode;
    vr = document.getElementById(campo).value;
    var tam = vr.length;
    
    if(tam == 5){
        document.getElementById(campo).value = vr.substr( 0, tam ) + '-' + vr.substr( tam , tam );
    }
//input type="text" id="cpf" value="" maxlength="14" onkeypress="return(formataCpf('cpf', event))"/>
}

function validaFormJur(){

    if (document.getElementById('cnpj').value == ""){
        document.getElementById('cnpj').style.backgroundColor = 'red';
        return (false);
    }else{
        return true;
    }

    return true;
}

function checaCampo(campo){
    if(campo.value == ''){
        campo.style.backgroundColor = '#fd6c83';
        return campo;
    }else{
        campo.style.backgroundColor = '#a4ffbe';
        return true;
    }

}

function checaEmail(email){
    if (email.value.search(/^\w+((-\w+)|(\.\w+))*\@\w+((\.|-)\w+)*\.\w+$/) == -1) {
        email.style.backgroundColor = '#fd6c83';
        jAlert("Por favor insira um E-mail válido !!", "ATENÇÃO");
        return false;
    }else{
        email.style.backgroundColor ='#a4ffbe';
        return true;
    }
}

function checkEnvia(envia){
    var i = 0;
    var nome = new Array();
    var texto;
    for (i = 0; i < envia.length; i++) {
        if(envia[i] != true){
            nome[i] = envia[i].alt;
        }
    }
    if(nome.length > 0){
        texto = "Por favor prencha os seguintes campos:\n\n";
        for (i = 0; i < nome.length; i++) {
            texto+= nome+"\n";
        }
        jAlert(texto,"Campos em branco!");
        return false;

    }


    return true;
}

function checaForm(formNome){
    var i;
    var nomes = new Array();
    var x = 0;
    var tem;
    var texto = "Por favor preencha os seguintes campos:<br><br>";
    for(i=0; i < document.forms[formNome].elements.length; i++){
      
        if(document.forms[formNome].elements[i].value == 'Selecione'){
            
            nomes[x] = document.forms[formNome].elements[i].title;
           
            x++;
        }
        if(document.forms[formNome].elements[i].alt != "undefined" && document.forms[formNome].elements[i].alt != "" && document.forms[formNome].elements[i].value == "" && document.forms[formNome].elements[i].type != "textarea"){
          
            if(document.forms[formNome].elements[i].alt != "undefined"){

                nomes[x] = document.forms[formNome].elements[i].alt;
                tem = true;
                x++;
            }
        }
    }
    if(nomes.length > 0){
        for(i = 0; i<nomes.length;i++){
            if(nomes[i] != ""){
                texto += nomes[i]+"<br>";
            }
        }
        
        jAlert(texto,'Campos em branco!');
        return false;
    }
    return true;
}


function checaFormCor(formNome){
    var i;
    var nomes = new Array();
    var x = 0;
    var texto = "Por favor repreencha os seguintes campos pois os dados inseridos são inválidos:<br><br>";
    for(i=0; i < document.forms[formNome].elements.length; i++){
        //        alert(document.forms[formNome].elements[i].style.backgroundColor);
        if(document.forms[formNome].elements[i].style.backgroundColor == "rgb(253, 108, 131)"){
       
            nomes[x] = document.forms[formNome].elements[i].alt;
            x++;
        }
    }
    if(nomes.length > 0){
        for(i = 0; i<nomes.length;i++){
            texto += nomes[i]+"<br>";
        }
        jAlert(texto,'ATENÇÃO!');
        return false;
    }
    return true;

}



function fazDiv(Tx,Ty,id){

    var conteudo = document.getElementById('conteudoo');
    conteudo.innerHTML=
    "<div id="+id+" style='width:"+Tx+";height:"+Ty+";margin:auto;background-color:blue'>  </div>"
    $(document).ready(function() {
        $('#'+id).draggable();
    //stop: function(){$(this).stayInBox($("#conteudoo"));
        
    });

    

}


var MD5 = function (string) {

    function RotateLeft(lValue, iShiftBits) {
        return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
    }

    function AddUnsigned(lX,lY) {
        var lX4,lY4,lX8,lY8,lResult;
        lX8 = (lX & 0x80000000);
        lY8 = (lY & 0x80000000);
        lX4 = (lX & 0x40000000);
        lY4 = (lY & 0x40000000);
        lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
        if (lX4 & lY4) {
            return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
        }
        if (lX4 | lY4) {
            if (lResult & 0x40000000) {
                return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
            } else {
                return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
            }
        } else {
            return (lResult ^ lX8 ^ lY8);
        }
    }

    function F(x,y,z) {
        return (x & y) | ((~x) & z);
    }
    function G(x,y,z) {
        return (x & z) | (y & (~z));
    }
    function H(x,y,z) {
        return (x ^ y ^ z);
    }
    function I(x,y,z) {
        return (y ^ (x | (~z)));
    }

    function FF(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    };

    function GG(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    };

    function HH(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    };

    function II(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    };

    function ConvertToWordArray(string) {
        var lWordCount;
        var lMessageLength = string.length;
        var lNumberOfWords_temp1=lMessageLength + 8;
        var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
        var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
        var lWordArray=Array(lNumberOfWords-1);
        var lBytePosition = 0;
        var lByteCount = 0;
        while ( lByteCount < lMessageLength ) {
            lWordCount = (lByteCount-(lByteCount % 4))/4;
            lBytePosition = (lByteCount % 4)*8;
            lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
            lByteCount++;
        }
        lWordCount = (lByteCount-(lByteCount % 4))/4;
        lBytePosition = (lByteCount % 4)*8;
        lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
        lWordArray[lNumberOfWords-2] = lMessageLength<<3;
        lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
        return lWordArray;
    };

    function WordToHex(lValue) {
        var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
        for (lCount = 0;lCount<=3;lCount++) {
            lByte = (lValue>>>(lCount*8)) & 255;
            WordToHexValue_temp = "0" + lByte.toString(16);
            WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
        }
        return WordToHexValue;
    };

    function Utf8Encode(string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";

        for (var n = 0; n < string.length; n++) {

            var c = string.charCodeAt(n);

            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    };

    var x=Array();
    var k,AA,BB,CC,DD,a,b,c,d;
    var S11=7, S12=12, S13=17, S14=22;
    var S21=5, S22=9 , S23=14, S24=20;
    var S31=4, S32=11, S33=16, S34=23;
    var S41=6, S42=10, S43=15, S44=21;

    string = Utf8Encode(string);

    x = ConvertToWordArray(string);

    a = 0x67452301;
    b = 0xEFCDAB89;
    c = 0x98BADCFE;
    d = 0x10325476;

    for (k=0;k<x.length;k+=16) {
        AA=a;
        BB=b;
        CC=c;
        DD=d;
        a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
        d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
        c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
        b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
        a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
        d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
        c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
        b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
        a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
        d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
        c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
        b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
        a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
        d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
        c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
        b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
        a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
        d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
        c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
        b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
        a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
        d=GG(d,a,b,c,x[k+10],S22,0x2441453);
        c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
        b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
        a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
        d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
        c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
        b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
        a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
        d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
        c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
        b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
        a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
        d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
        c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
        b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
        a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
        d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
        c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
        b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
        a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
        d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
        c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
        b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
        a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
        d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
        c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
        b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
        a=II(a,b,c,d,x[k+0], S41,0xF4292244);
        d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
        c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
        b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
        a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
        d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
        c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
        b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
        a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
        d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
        c=II(c,d,a,b,x[k+6], S43,0xA3014314);
        b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
        a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
        d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
        c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
        b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
        a=AddUnsigned(a,AA);
        b=AddUnsigned(b,BB);
        c=AddUnsigned(c,CC);
        d=AddUnsigned(d,DD);
    }

    var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);

    return temp.toLowerCase();
}

function erro(id,msg){
    var div = document.getElementById(id);
    div.innerHTML = msg;
}

function escreveDiv(id, msg){

}

function clearSelect( field )
{
    var t= field.options.length;
    for(var i=0; i<t;i++)
    {
        field.options[0]=null;
    }
    field.selectedIndex=-1;
}

function addSelectOption(selectElement,newText,newValue)
{
    var newOption = new Option();
    newOption.text = newText;
    newOption.value = newValue;
    try
    {
        selectElement.add(newOption,null);
    }
    catch(e)
    {
        selectElement.add(newOption,selectElement.length);
    }
    return newOption;
}
