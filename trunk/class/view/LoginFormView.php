<?php

session_start();


include_once 'lib/conexao.php';
include_once 'lib/DB.class.php';
include_once 'lib/funcoes.php';
include_once 'Model/UsuariosLogs.class.php';

class Login
{

    public static function logout($tipo = null)
    {

        if (!$_SESSION['monitoramento']['usuarioId'])
        {
            unset($_SESSION['monitoramento']);
            echo " <script>location.href = 'index.php';</script>";
            return true;
        }

        unset($_SESSION['monitoramento']);

        echo " <script>location.href = 'index.php';</script>";
    }

    public static function testaLogin()
    {
        $db = new DB();
        $db->conectar();

        $objUsuario = $db->selectUmaLinha("select * from usuarios where login = '{$_POST['login']}' and fl_ativo ='1' ");
        
        $senha = md5($_POST['senha']);
        if($objUsuario->fl_acesso)
        {
            unset($objUsuario);
            $sql = "SELECT *  from usuarios  where login = '{$_POST['login']}' and senha = '{$senha}' and fl_ativo = '1' ";
            $objUsuario = $db->selectUmaLinha($sql);
        }
        else
        {
            $objSenha->senha = $senha;
            $objSenha->fl_acesso = 1;
            $db->update('usuarios', $objSenha, $objUsuario->usuarioId);
        }
        
        if ($objUsuario)
        {
            $_SESSION['monitoramento']['usuarioId'] = $objUsuario->usuarioId;
            $_SESSION['monitoramento']['nome'] = $objUsuario->nome;

            $objTipoUsuario = $db->selectUmaLinha("SELECT * from tiposUsuarios where tipoUsuarioId = {$objUsuario->tipoUsuarioId}");

            $_SESSION['monitoramento']['tipoUsuarioId'] = $objTipoUsuario->tipoUsuarioId;
            $_SESSION['monitoramento']['tipo'] = $objTipoUsuario->descricao;

            if ($objTipoUsuario->tipoUsuarioId == 3)
            {
                $modulos = $db->selectMultiLinhas("select M.* from modulos M  group by M.id");
            }
            else
            {
                $modulos = $db->selectMultiLinhas("select M.* from modulos M, permissoes P where P.ref_usuario = {$_SESSION['monitoramento']['usuarioId']} and P.ref_modulo = M.id group by M.id");
            }
            foreach ($modulos as $modulo)
            {
                $menu .=
                        "
                <div style='float:left;width: 50px;cursor: pointer;'>
                    <a  style='color:black;'onclick=\"maisTempo(); requestPage('{$modulo->url}','conteudo','GET','','#!{$modulo->amigavel}');\">
                        <img title='{$modulo->descricao}'src='{$modulo->icone}'/> 
                    </a>
                </div>
            ";
            }

            $_SESSION['monitoramento']['menu'] = $menu;

            echo " <script>location.href = 'index.php';</script>";
        }
        else
        {
            echo"
            <script>jAlert('Usuário ou senha inválidos!','Ops..')</script>";
        }
    }

    public static function show()
    {
        echo '
                <html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                        <link href="lib/css/login.css" rel="stylesheet" type="text/css" />
                        <link href="lib/jquery.alerts.css" rel="stylesheet" type="text/css" />
                        <link href="lib/css/jquery-ui.css" rel="stylesheet" type="text/css" />
                        <link href="lib/css/jquery.alerts.css" rel="stylesheet" type="text/css" />
                        <link href="lib/css/skin.css" rel="stylesheet" type="text/css" />
                        
                        <script type="text/javascript" src="lib/js/jquery.js"></script>        
                        <script type="text/javascript" src="lib/js/jquery.easing.js"></script>
                        <script type="text/javascript" src="lib/js/jquery.lavalamp.min.js"></script>
                        <script type="text/javascript" src="lib/js/jquery-ui.js"></script>
                        <script type="text/javascript" src="lib/js/jquery.alerts.js"></script>
                        <script type="text/javascript" src="lib/js/jquery.jcarousel.min.js"></script>                        
                        <script type="text/javascript" src="lib/js/datepickerBr.js"></script>
                        <script type="text/javascript" src="lib/bookmarks/bookmarks.js"></script>
                        <script type="text/javascript" src="lib/js/uploadfile.js"></script>    


                        <script type="text/javascript" src="lib/js/tools.js"></script>
                    </head>

                    <body class="loginform">

                        

                        <div class="container" style="width: 350px; margin-top:120px; ">
                            
                            <div style="width:300px; height:90px; padding-bottom:50px;">
                                <img  src="lib/css/images/logo.png"  />                            
                            </div>


                            <form class="login" id ="login_form" name="login_form" method="post" onsubmit = "requestPage(\'ajax.php?class=Login::testaLogin()\',\'carrega\',\'POST\',BuscaElementosForm(\'login_form\')); return false;" >
                                <fieldset>
                                    <legend>
                                        Log in
                                    </legend>

                                    <div class="item">
                                        <label for="input_username">Usuário:</label>
                                        <input type="text" class="textfield" size="24" value="" id="input_username" name="login">
                                    </div>
                                    
                                    <div class="item">
                                        <label for="input_password">Senha:</label>
                                        <input type="password" class="textfield" size="24" value="" id="input_password" name="senha">
                                    </div>
                               </fieldset>
                                        <fieldset class="tblFooters">
                                            <input type="submit" id="input_go" value="Entrar">
                                        </form>
                                    </div>
                              <div id = "teste"></div>      
                                        
                        </body>
                </html>
    ';
    }

}
