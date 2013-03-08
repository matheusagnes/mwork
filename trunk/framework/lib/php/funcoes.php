<?php

include_once 'phpmailer/class.phpmailer.php';

function verificaPost($post)
{
    $ok = false;
    foreach ($post as $value)
    {
        if(is_array($value))
        {
            foreach ($value as $v)
            {
                if($v)
                {
                    $ok = true;
                }
            }
            if(!$ok)
            {
                return false;
            }
        }
        else if(!trim($value))
        {
            
            return false;
        }
    }
    
    return true;
}


function format_size($size)
{    set_time_limit(0);

    $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    if ($size == 0)
    {
        return('n/a');
    }
    else
    {
        return (round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);
    }
}

function diferencaHoras($horaFim, $horaIni)
{
    $horaFim = explode(':', $horaFim);
    $horaIni = explode(':', $horaIni);
    
    $difHoras = $horaFim[0] - $horaIni[0];
    $difMins  = $horaFim[1] - $horaIni[1];
    
    if($difMins < 0 )
    {
        $difMins = $difMins * -1;        
    }
    
    if($difHoras < 0 )
    {
        $difHoras = $difHoras * -1;        
    }
    
    if($difHoras < 9)
    {
        $difHoras = "0{$difHoras}";
    }
    
    if($difMins < 9)
    {
        $difMins = "0{$difMins}";
    }
        
    
    $difTempo = "{$difHoras}:{$difMins}:{$horaFim[2]}";
    
    return $difTempo;
}

function invDataBraUsa($data)
{
    $dataS = str_replace('/','-',$data);
    $dataS = substr($dataS,0,10);

    if (strlen($dataS) == 10)
    {
        $data_array = explode ('-',$dataS);
        if (strlen($data_array[0]) == 4)
        {
            return $data;
        }
        else
        {
            $dia  = substr($dataS, 0, 2);
            $mes  = substr($dataS, 3, 2);
            $ano  = substr($dataS, 6, 4);
            $dataS = "$ano-$mes-$dia";
            if (strlen($data) > 10)
            {
                $dataS .= ' '.substr($data,11,8);
            }
            return $dataS;
        }
    }
    else

        return false;

}

function invDataUsaBra($data)
{
    $dataS = str_replace('/','-',$data);
    $dataS = substr($dataS,0,10);

    if (strlen($dataS) == 10)
    {
        $data_array = explode ('-',$dataS);
        if (strlen($data_array[0]) == 2)
            {
                return $data;
            }
            else
            {
                $ano  = substr($dataS, 0, 4);
                $mes  = substr($dataS, 5, 2);
                $dia  = substr($dataS, 8, 2);
                $dataS = "$dia-$mes-$ano";
                if (strlen($data) > 10)
                {
                    $dataS .= ' '.substr($data,11,8);
                }
                return $dataS;
            }
    }
    else
        return false;
}

//function oMensagem($mensagem, $acao='javascript:history.go(-1)'){
function mensagem($mensagem, $acao=null)
{
    if ($acao == null)
    {
        $acao = $_SERVER['HTTP_REFERER'];
    }
    $html = " <div class='oMensagem'> <h1> Mensagem  </h1>
                <div class='oTextoMensagem'> $mensagem </div>
               <button $acao>ok</button></div> ";
    return $html;
}

function sucesso($msg, $url, $div='conteudo', $titulo='Sucesso!')
{
    return
    "<script>           
            alertaR('$msg','$titulo','$url','$div');
        </script>";
}

function message($tipo, $msg, $titulo, $url = null, $div = null)
{
    if ($tipo == 'error')
    {
        echo
        "<script>           
                jAlert('$msg','$titulo');
        </script>";
    }

    if ($tipo == 'success')
    {
        echo
        "<script>           
            alertaR('$msg','$titulo','$url','$div');
        </script>
        ";
    }
    
    if($tipo == 'alert')
    {
        echo
        "<script>           
                jAlert('$msg','$titulo');
        </script>";
    }
}

function error($msg, $url)
{
    return
    "
        <script>
            var texto = '$msg !';
            var url = '$url';
            var titulo = 'Opss!';
            var div = 'conteudo';
            alertaR(texto,titulo,url,div);
        </script>
    ";
}

function jError($objDados)
{
    return
    "
        <script>
            jAlert('{$objDados->mensagem}','{$objDados->titulo}');
        </script>
    ";
}

/* Retorna 0 se falso e 1 se verdadeiro */

function validaCpf($cpf)
{
    /*
     */
    $nulos = array("12345678909", "11111111111", "22222222222", "33333333333",
        "44444444444", "55555555555", "66666666666", "77777777777",
        "88888888888", "99999999999", "00000000000");
    /* Retira todos os caracteres que nao sejam 0-9 */
    $cpf = ereg_replace("[^0-9]", "", $cpf);

    /* Retorna falso se houver letras no cpf */
    if (!(ereg("[0-9]", $cpf)))
        return false;

    /* Retorna falso se o cpf for nulo */
    if (in_array($cpf, $nulos))
        return false;

    /* Calcula o penúltimo dígito verificador */
    $acum = 0;
    for ($i = 0; $i < 9; $i++)
    {
        $acum+= $cpf[$i] * (10 - $i);
    }

    $x = $acum % 11;
    $acum = ($x > 1) ? (11 - $x) : 0;
    /* Retorna falso se o digito calculado eh diferente do passado na string */
    if ($acum != $cpf[9])
    {
        return false;
    }
    /* Calcula o último dígito verificador */
    $acum = 0;
    for ($i = 0; $i < 10; $i++)
    {
        $acum+= $cpf[$i] * (11 - $i);
    }

    $x = $acum % 11;
    $acum = ($x > 1) ? (11 - $x) : 0;
    /* Retorna falso se o digito calculado eh diferente do passado na string */
    if ($acum != $cpf[10])
    {
        return false;
    }
    /* Retorna verdadeiro se o cpf eh valido */
    return true;
}

function validaCNPJ($cnpj)
{
    if (strlen($cnpj) <> 18)
        return 0;
    $soma1 = ($cnpj[0] * 5) +
            ($cnpj[1] * 4) +
            ($cnpj[3] * 3) +
            ($cnpj[4] * 2) +
            ($cnpj[5] * 9) +
            ($cnpj[7] * 8) +
            ($cnpj[8] * 7) +
            ($cnpj[9] * 6) +
            ($cnpj[11] * 5) +
            ($cnpj[12] * 4) +
            ($cnpj[13] * 3) +
            ($cnpj[14] * 2);
    $resto = $soma1 % 11;
    $digito1 = $resto < 2 ? 0 : 11 - $resto;
    $soma2 = ($cnpj[0] * 6) +
            ($cnpj[1] * 5) +
            ($cnpj[3] * 4) +
            ($cnpj[4] * 3) +
            ($cnpj[5] * 2) +
            ($cnpj[7] * 9) +
            ($cnpj[8] * 8) +
            ($cnpj[9] * 7) +
            ($cnpj[11] * 6) +
            ($cnpj[12] * 5) +
            ($cnpj[13] * 4) +
            ($cnpj[14] * 3) +
            ($cnpj[16] * 2);
    $resto = $soma2 % 11;
    $digito2 = $resto < 2 ? 0 : 11 - $resto;
    return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2));
}

function redimensionaImagem($file_name, $max_width, $max_height)
{

    list ($width, $height) = getimagesize($file_name);

    if ($width == $max_width && $height == $max_height)
    {
        return true;
    }

//    if (($width / $max_width) == ($height / $max_height))
//    {
//        $new_width = $max_width;
//        $new_height = $max_height;
//    } else
//    {
//        if (($width / $max_width) > ($height / $max_height))
//        {
//            $new_width = $max_width;
//            $new_height = $max_width * ($height / $width);
//        } else
//        {
//            $new_height = $max_height;
//            $new_width = $max_height * ($width / $height);
//        }
//    }
    $image_p = imagecreatetruecolor($max_width, $max_height);

    $file_extension = substr(strrchr($file_name, '.'), 1);
    $file_extension = strtoupper($file_extension);

    switch ($file_extension)
    {
        case 'JPG':
            $image = imagecreatefromjpeg($file_name);
            break;

        case 'JPEG':
            $image = imagecreatefromjpeg($file_name);
            break;

        case 'GIF':
            $image = imagecreatefromgif($file_name);
            break;

        case 'PNG':
            $image = imagecreatefrompng($file_name);
            break;

        case 'BMP':
            $image = imagecreatefromwbmp($file_name);
            break;

        default:
            break;
    }

    if (!$image)
    {
        return false;
    }

    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $max_width, $max_height, $width, $height);

    switch ($file_extension)
    {
        case 'JPG': return imagejpeg($image_p, $file_name, 100);
        case 'JPEG': return imagejpeg($image_p, $file_name, 100);
        case 'GIF': return imagegif($image_p, $file_name);
        case 'PNG': return imagepng($image_p, $file_name);
        case 'BMP': return imagewbmp($image_p, $file_name);
    }

    return false;
}

function geraCombo($nomeSelect, $col1, $col2, $sql, $id)
{
    conectaBD();
    if ($dados = mysql_query($sql))
    {
        $option = "<SELECT name='" . $nomeSelect . "'> ";
        while ($linha = mysql_fetch_array($dados))
        {
            extract($linha);

            if ($linha[$col1] == $id)
            {
                $option .= "
                    <option value='" . $linha[$col1] . "' selected>" . $linha[$col2] . "</option> ";
            } else
            {
                $option .= "
                    <option value='" . $linha[$col1] . "'>" . $linha[$col2] . "</option> ";
            }
        }
        $option .= "</SELECT>";
        return $option;
    }
}

//function substituiAcentos($var) {
//// Substitue acentos.
//    $var = ereg_replace("[ÁÀÂÃ]", "A", $var);
//    $var = ereg_replace("[áàâãª]", "a", $var);
//    $var = ereg_replace("[ÉÈÊ]", "E", $var);
//    $var = ereg_replace("[éèê]", "e", $var);
//    $var = ereg_replace("[ÓÒÔÕ]", "O", $var);
//    $var = ereg_replace("[óòôõº]", "o", $var);
//    $var = ereg_replace("[ÚÙÛ]", "U", $var);
//    $var = ereg_replace("[úùû]", "u", $var);
//    $var = str_replace("Ç", "C", $var);
//    $var = str_replace("ç", "c", $var);
//
//    return $var;
//}

function checarEmail($email)
{

    if (ereg("^([0-9,a-z,A-Z]+)([.,_]([0-9,a-z,A-Z]+))*[@]([0-9,a-z,A-Z]+)([.,_,-]([0-9,a-z,A-Z]+))*[.]([0-9,a-z,A-Z]){2}([0-9,a-z,A-Z])?$", $email))
    {
        return true;
    } else
    {
        return false;
    }
}

function VerifyEmailAddress($EMail)
{
    list($User, $Domain) = explode("@", $EMail);
    $Result = checkdnsrr($Domain, "MX");
    return($Result);
}

function gerar_dv_nossonumero($numero)
{
    $resto2 = calc_modulo_11($numero, 7, 1);
    $digito = 11 - $resto2;
    if ($digito == 10)
    {
        $dv = "P";
    } elseif ($digito == 11)
    {
        $dv = 0;
    } else
    {
        $dv = $digito;
    }
    return $dv;
}

function calc_modulo_11($num, $base=9, $r=0)
{

    $soma = 0;
    $fator = 2;

    /* Separacao dos numeros */
    for ($i = strlen($num); $i > 0; $i--)
    {
// pega cada numero isoladamente
        $numeros[$i] = substr($num, $i - 1, 1);
// Efetua multiplicacao do numero pelo falor
        $parcial[$i] = $numeros[$i] * $fator;
// Soma dos digitos
        $soma += $parcial[$i];
        if ($fator == $base)
        {
// restaura fator de multiplicacao para 2
            $fator = 1;
        }
        $fator++;
    }

    /* Calculo do modulo 11 */
    if ($r == 0)
    {
        $soma *= 10;
        $digito = $soma % 11;
        if ($digito == 10)
        {
            $digito = 0;
        }
        return $digito;
    } elseif ($r == 1)
    {
        $resto = $soma % 11;
        return $resto;
    }
}

function formatar_numero($numero)
{
    return str_replace('.', ',', $numero);
}

function formatar_datahora($datahora, $formato = 'd/m/Y - H:i')
{
    if (!$datahora)
    {
        return $datahora;
    }
    return date($formato, strtotime($datahora));
}

function formatar_data($datahora, $formato = 'd/m/Y')
{
    return formatar_datahora($datahora, $formato);
}

function formatar_hora($datahora, $formato = 'H:i')
{
    return formatar_datahora($datahora, $formato);
}

function mostraProdutosOrdemServico($linhaProdutos)
{

    include_once 'lib/oDB.class.php';
//        $produtoId      = $_POST[produtoId];
//        $produtoIdTodos = $_POST[produtoIdTodos];
    $codfil = trim($_SESSION[iseg_oxi][codfil]);


    $db = new oDB();
    $db->conectar();


// $con = new conexao;
//            $con->conectaDB('sol');
//        if(trim($produtoIdTodos)==0){
//            $produtoIdTodos .= $produtoId;
//        }else{
//            $produtoIdTodos .="," . $produtoId;
//        }
//  $codigos = explode(',',$produtoIdTodos);


    $sql = " select produtoId, nome as nomeProduto, valor from produtos where empresaId = 4  ";



    $addOr = false;

//  if(strlen(trim($produtoIdTodos))>0){
    if (is_array($linhaProdutos))
    {
// $sql .= " and b.produtoId IN (".$codigo.") ";
// $codigos = explode(',',$itens);
//for($x=0;$x<count($codigos); $x++){
        foreach ($linhaProdutos as $x => $linha)
        {
            $codigo = trim($linha[produtoId]);
// verifica se há numero com dígito.
            if (strlen($codigo) > 0)
            {
// extraí o dígito.
// $codigo_item = substr($codigo, 0, strlen(trim($codigo))-1);
                if ($addOr)
                {
                    $sqlc .= " or ";
                }

                $sqlc .= "  ( produtoId = ";
// $codigo = trim($codigos[$x]);
//$codigo_produtoId = $codigo;
// $codigo_produtoId = $codigo_item;
                $sqlc .= $codigo;
//                            $addVirgula = false;
// $codembaln = $_POST[$codigo_produtoId."_codembal"];



                $addOr = true;
                $sqlc .= " )";
            }
        }
    }
//  }
    if (strlen(trim($sqlc)) > 0)
    {
        $sql .= " AND (" . $sqlc . " )";
    }

    $sql .= " order by produtoId ";

    $msgAviso = "";

    $itemAdd = true;




// <h1> Relatório de Simulação de preços/margem </h1>
    $html .= "
                <br>
                <br>


                  <input name='itemExcluir' id='itemExcluir' value='' type='hidden' >
                   <div id=tabelaDiv >      $htmlSusp
                  <div id=tabelaTodaDiv >
                  <table class='tabGeral' id=tabelaToda  bgcolor='#c1c1c1'  >
                    <tr>
                        <td id='cabFundo' style=' width:25px; ' >-----</td>
                        <td id='cabFundo' style=' width:50px; ' > Item </td>
                        <td id='cabFundo' style=' width:300px; ' > Descrição </td>
                        <td id='cabFundo' style=' width:45px; ' > Preço </td>
                        <td id='cabFundo' style=' width:55px; ' > Quant. </td>
                        <td id='cabFundo' style=' width:55px; ' > Pr.Unit. </td>
                        <td id='cabFundo' style=' width:55px; ' > Total Prod.</td>
                    </tr> ";



// Pega campos que deve excluir da listagem:
    if (strlen(trim($_POST[itemExcluir])) > 0)
    {
        $itemÈxcluir = explode('_', $_POST[itemExcluir]);


        $produtoExcluir = $itemÈxcluir[0];
// $sql .= " and ( e.produtoId != {$itens[1]} and e.codembal != {$itens[0]} )";
    }

    $res = mysql_query($sql);
    $nl = mysql_num_rows($res);
    if ($res != false and $nl > 0)
    {

        $nlinhasGrid = 0;
// Linhas do arquivo
        while ($linha = mysql_fetch_array($res))
        {
            $addLinha = true;
            $coditem = trim($linha[produtoId]);
            $cadastrook = true;
            $cadastrookicms = true;
            $cadastrookicms2 = true;
            $alAviso = '';
            $alAviso2 = '';
            $alAviso3 = '';


// Não adiciona itens à listagem.
            if ($produtoExcluir == trim($linha[produtoId]))
            {
                $addLinha = false;
            }


            if ($addLinha)
            {

                if (trim($todosItensAdicionados) == 0)
                {
                    $todosItensAdicionados .= trim($linha[produtoId]);
                } else
                {
                    $todosItensAdicionados .="," . trim($linha[produtoId]);
                }



                $c++;
                if ($c % 2 == 0)
                {
                    $cor = "#f2f2f2";
                } else
                {
                    $cor = "#ffffff";
                }

                $qtSolicitado = '';
                $sugestaoSoma = '';
                $valorSolicitado = '';

                foreach ($linhaProdutos as $keyPr => $linhaProd)
                {
                    if ($linhaProd[produtoId] == trim($linha[produtoId]))
                    {
                        $qtSolicitado = $linhaProd[quantidade];
                        $valorSolicitado = $linhaProd[valorUnit];
                        $sugestaoSoma = $linha[valorTotal];
                    }
                }


                $qtSolicitado = strlen($qtSolicitado) > 0 ? $qtSolicitado : 1;
                $valorSolicitado = strlen($valorSolicitado) > 0 ? $valorSolicitado : $linha[valor];
                $sugestaoSoma = strlen($sugestaoSoma) > 0 ? $sugestaoSoma : $qtSolicitado * $valorSolicitado;



                $html .= "
                            <tr id='" . trim($linha[produtoId]) . "_linhaGrid' bgcolor='$cor' onMouseOver=\"this.style.backgroundColor='#e8e8e8';\" onMouseOut=\"this.style.backgroundColor='$cor';\" >
                            <td> <input  onclick=\"excluiLinha('" . trim($linha[produtoId]) . "_linhaGrid');  ajaxPost('produtoId','divAjax', 'produtosOrcamentoAjax.php?form=pegaItens', 'oForm' ); \" name='" . trim($linha[produtoId]) . "_btExclui' id='" . trim($linha[produtoId]) . "_btExclui' type='button' class='btn' value='X' > </td>
                            <td>" . trim($linha[produtoId]) . "</td><td>" . trim($linha[nomeProduto]) . "</td> ";

// <td align=right  >".number_format($porcentagem,2,',','')."</td>
                $html .= "   <td align=right  >" . number_format($linha[valor], 2, ',', '') . "</td> ";

                $html .="

                            <td align=right  > <input  onfocus=\"limpaCampoZero('" . trim($linha[produtoId]) . "_quantidade'); setCursorAtEnd(this); \"  autocomplete=\"off\"    OnKeyDown=\"formataFloat('" . trim($linha[produtoId]) . "_quantidade', event);   \" onBlur=\"  fazSomaLinha('" . trim($linha[produtoId]) . "_valor', '" . trim($linha[produtoId]) . "_quantidade', '" . trim($linha[produtoId]) . "_soma' ); somaTotais('produtoIdTodos','somaTotal'); \" name='" . trim($linha[produtoId]) . "_quantidade' id='" . trim($linha[produtoId]) . "_quantidade' type='text' class='campos'  style='width:50px; ' value='$qtSolicitado' ></td>
                            <td align=right  > <input  onfocus=\"limpaCampoZero('" . trim($linha[produtoId]) . "_valor'); setCursorAtEnd(this); \"  autocomplete=\"off\"    OnKeyDown=\"formataFloat('" . trim($linha[produtoId]) . "_valor', event);   \" onBlur=\"  fazSomaLinha('" . trim($linha[produtoId]) . "_valor', '" . trim($linha[produtoId]) . "_quantidade', '" . trim($linha[produtoId]) . "_soma' ); somaTotais('produtoIdTodos','somaTotal'); \" name='" . trim($linha[produtoId]) . "_valor' id='" . trim($linha[produtoId]) . "_valor' type='text' class='campos'  style='width:50px; ' value='$valorSolicitado' ></td> ";


                $html .="
                            <td align=right  >
                                <input name='" . trim($linha[produtoId]) . "_soma' id='" . trim($linha[produtoId]) . "_soma' value='" . number_format($sugestaoSoma, 2, '.', '') . "'  class='camposInativo' style='width:50px; ' disabled=disabled >
                            </td>
                           </tr>

                             ";
// onBlur=\"fazSimulacao('".trim($linha[produtoId])."_margem','".trim($linha[produtoId])."_valor', $impostos, '".trim($linha[produtoId])."_cmup', '".trim($linha[produtoId])."_soma', '".trim($linha[produtoId])."_margem', '".trim($linha[produtoId])."_margemD', '".trim($linha[produtoId])."_somaD' );\"
                $htmlCodembal .= " <input value='" . trim($linha[codembal]) . "' name='" . trim($linha[produtoId]) . "_codembal[]' type='hidden' > ";


                $todosCamposQuant .= trim($linha[produtoId]) . "_quantidade||";
                $todosCamposMargem .= trim($linha[produtoId]) . "_margemD||";
                $todosCamposSoma .= trim($linha[produtoId]) . "_somaD||";
            }
        }

//   $arrayArquivos[$codfil][total] = $valorTotalLevantamento;
//   $arrayArquivos[$codfil][sequencia] = $seq;
//   $valorTotalLevantamento = 0;
    } else
    {
        $html .= "<tr><td colspan=20 bgcolor='#c1c1c1'> Item não encontrado para filial $codfil. </td> </tr> ";
    }

    $somaTotal = $_POST['somaTotal'];



    $html .= " </table>
                         </div>
                        <table class='tbTotais' ><tr>
                            <td style=' width:450px; ' ></td>

                            <td>Total Soma:</td>
                               <td> <input type='text' id='somaTotal' name='somaTotal'  value='$somaTotal' class='camposInativo' style=' width:70px;' disabled=disabled >
                            </td>


                          </tr>
                     </table>
                         </div>
                            <br><div align=center >
                    $htmlCodembal
                    <input type='hidden' value='' id='geraExcel' name='geraExcel' >
                    <input type='hidden' value='$todosCamposQuant' id='todosCamposQuant' name='todosCamposQuant' >
                     <input type='hidden' value='$todosCamposMargem' id='todosCamposMargem' name='todosCamposMargem' >
                     <input type='hidden' value='$todosCamposSoma' id='todosCamposSoma' name='todosCamposSoma' >
                     <input type='hidden' value='$_POST[validado]' id='validado' name='validado' >
                     <input type='hidden' value='$_POST[validadoPor]' id='validadoPor' name='validadoPor' >
                     <input type='hidden' value='$alcadaatacado' id='alcadaatacado' name='alcadaatacado' >
                     <input id='produtoIdTodos' name='produtoIdTodos' value='$todosItensAdicionados' type='hidden' >
                    </div> ";

    if (strlen(trim($msgAviso)) > 0)
    {
        $html .= " <div class='msgAviso' > <b> Atenção: </b> <br> Item(s) sem estoque suficiente: <br> $msgAviso </div>         ";
    }
//  <input type=submit name='Adicionar1' value=' Adicionar '  onclick=\"simulacaoAjax('produtoId','divAjax', 'inc/itensSimulacaoAjax.php?form=pegaItens' );\" >
//                             <input type='submit' name='ENVIAR' value='Atualizar sugestões' style='width:350px; ' >
// necessário para utf8
//  echo utf8_encode($html);
// echo $html;
// return $html;
    return $html;
}


function parseGet($get)
{
    $cont = 0;
    foreach ($get as $key => $valor)
    {
        if (is_array($valor))
        {
            foreach ($valor as $v)
            {
                if ($cont == 0)
                {
                    $url.= "?$key%5B%5D=$v";
                } else
                {
                    $url.= "&$key%5B%5D=$v";
                }
            }
        } else
        {
            if ($cont == 0)
            {
                $url.= "?$key=$valor";
            } else
            {
                $url.= "&$key=$valor";
            }
        }
        $cont++;
    }    
    return $url;
}


function sendMail($mensagem, $emails, $subJect)
{   
    $phpmailer = new PHPMailer();
    $phpmailer->IsSMTP();
    $phpmailer->SMTPAuth = true;
    $phpmailer->Host = 'smtp.gmail.com';
    $phpmailer->Port = '587';
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->Username = 'contato@deliverysnovale.com.br';
    $phpmailer->Password = '@#delivery@#vale';
    $phpmailer->CharSet = 'UTF-8';
    $phpmailer->SetLanguage("br");
    $phpmailer->IsHTML(true);
    $phpmailer->SetFrom('contato@deliverysnovale.com.br', 'Deliverys no Vale');
    $phpmailer->AddReplyTo('contato@deliverysnovale.com.br', 'Deliverys no Vale');
    $phpmailer->AddReplyTo('matheusagnes@gmail.com', 'Matheus Agnes Dias');
    
    if(is_array($emails))
    {
        foreach ($emails as $email) 
        {
            $phpmailer->AddAddress($email);    
        }
    }
    else
    {
        $phpmailer->AddAddress($emails);
    }
    
    $phpmailer->Subject = $subJect;
    $phpmailer->Body = $mensagem;

    return $phpmailer->Send();
}

function highLight($message, $highLightType = 'info', $div = 'high-light')
{
    if($highLightType == 'error')
    {
        $type = 'alert-error';
    }
    elseif($highLightType == 'success')
    {
        $type = 'alert-success';
    }
    elseif($highLightType == 'info')
    {
        $type = 'alert-info';
    }

    $html = 
    "
        <div id='my-alert'class='alert {$type} fade in'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            {$message}
        </div>
    ";
    $html = str_replace("\n", '', $html);

    echo
    "
        <script>
            $('#{$div}').html(\"{$html}\").alert();
        </script>
    ";
}

?>
