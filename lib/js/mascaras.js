/**
  * Criado em 3/11/2008
  * Banco Votorantim
  * BV-Sistemas
  * @author Daniel Cassoli
  * @contributors
  * @version 1.0
  * @abstract (descrição)
  * Atualizado em XX por XX
  * Responsável: João Batista
  *
  * Ex.: <input id="icnpj" onkeypress="mascara(this,cnpj)" maxlength="18" class="input" name="cnpjPj">
***/


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

/*Função que Determina as expressões regulares dos objetos*/
function leech(v){
  v=v.replace(/o/gi,"0")
  v=v.replace(/i/gi,"1")
  v=v.replace(/z/gi,"2")
  v=v.replace(/e/gi,"3")
  v=v.replace(/a/gi,"4")
  v=v.replace(/s/gi,"5")
  v=v.replace(/t/gi,"7")
  return v
}


/*Função que padroniza placa de veiculo*/
function placa(v){
  v=v.replace(/^(\d{3})/,"") //Remove tudo o que é dígito nos 3 primeiras posições
  //v=v.replace(/$(\D{3})/,"$1") //Remove tudo o que é caractere nos 4 ultimas posições
  //v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
  //v=v.replace(/^([A-Z]{3}){3}[0-9]{4}$/,"");
  //v=v.replace(/(\d)(\d{2})$/,"$1.$2") //Coloca ponto antes dos 2 últimos digitos
  return v.toUpperCase();
}

/*Função que padroniza valores*/
function moeda(v){
  v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
  //v=v.replace(/^([0-9]{3}\.?){3}-[0-9]{2}$/,"$1.$2");
  v=v.replace(/(\d)(\d{2})$/,"$1.$2") //Coloca ponto antes dos 2 últimos digitos
  return v
}

function moedaMilhar(v) {
  v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
  //v=v.replace(/^([0-9]{3}\.?){3}-[0-9]{2}$/,"$1.$2");
  v=v.replace(/(\d)(\d{5})$/,"$1.$2") //Coloca virgula antes dos 5 últimos digitos
  v=v.replace(/(\d)(\d{2})$/,"$1,$2") //Coloca ponto antes dos 2 últimos digitos
  return v
}

/*Função que padroniza telefone (11) 4184-1241*/
function telefone(v){
  v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
  v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
  v=v.replace(/(\d{4})(\d)/,"$1-$2") //Coloca hífen entre o quarto e o quinto dígitos
  return v
}

/*Função que padroniza Data: 22/11/2008 */
function data(v){
  v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
  v=v.replace(/^(\d\d)(\d)/g,"$1/$2") //Coloca barra entre os dois primeiros dígitos
  v=v.replace(/(\d{2})(\d)/,"$1/$2") //Coloca barra entre o quinto e o sexto dígitos
  return v
}

/*Função que padroniza Hora: 11:11 */
function hora(v){
  v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
  v=v.replace(/(\d{2})(\d)/,"$1:$2")
  return v
}

/*Função que padroniza CPF: 999.999.999-88 */
function cpf(v){
  v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
  v=v.replace(/(\d{3})(\d)/,"$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
  v=v.replace(/(\d{3})(\d)/,"$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
  //de novo (para o segundo bloco de números)
  v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
  return v
}

/*Função que padroniza CEP: 44444-555*/
function cep(v){
  v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
  v=v.replace(/^(\d{5})(\d)/,"$1-$2")
  return v
}

/*Função que padroniza CNPJ: 99.999.999/0001-88 */
function cnpj(v){
  v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
  v=v.replace(/^(\d{2})(\d)/,"$1.$2") //Coloca ponto entre o segundo e o terceiro dígitos
  v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
  v=v.replace(/\.(\d{3})(\d)/,".$1/$2") //Coloca uma barra entre o oitavo e o nono dígitos
  v=v.replace(/(\d{4})(\d)/,"$1-$2") //Coloca um hífen depois do bloco de quatro dígitos
  return v
}

/*Função que padroniza o Site*/
function site(v){
  v=v.replace(/^http:\/\/?/,"")
  dominio=v
  caminho=""
  if(v.indexOf("/")>-1)
    dominio=v.split("/")[0]
  caminho=v.replace(/[^\/]*/,"")
  dominio=dominio.replace(/[^\w\.\+-:@]/g,"")
  caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"")
  caminho=caminho.replace(/([\?&])=/,"$1")
  if(caminho!="")dominio=dominio.replace(/\.+$/,"")
    v="http://"+dominio+caminho
  return v
}

/*Função que padroniza milhar ex: 2.000 */
function milhar(v){
  v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
  v=v.replace(/^([0-9]{3}\.?){3}-[0-9]{2}$/,"$1.$2");
  v=v.replace(/(\d)(\d{2})$/,"$1.$2") //Coloca ponto antes dos 2 últimos digitos
  return v
}

/*******************************************************************************************/
