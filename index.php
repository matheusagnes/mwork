<?php
include_once 'framework/MCore.php';

$mcore = new MCore();
$mcore = $mcore->getInstance();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" http://www.w3.org/TR/html4/stric.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


        <link href="framework/lib/css/jquery-ui.css" rel="stylesheet" type="text/css" />
        <link href="framework/lib/css/framework.css" rel="stylesheet" type="text/css" />
        <link href="framework/lib/css/ajax.css" rel="stylesheet" type="text/css" />
        
        <script type="text/javascript" src="framework/lib/js/jquery.js"></script>
        <script type="text/javascript" src="framework/lib/js/jquery-ui.js"></script>
        
        <script type="text/javascript" src="framework/lib/js/ajax/jquery.ba-bbq.js"></script>
        <script type="text/javascript" src="framework/lib/js/open_dialog_ui.js"></script>
        <script type="text/javascript" src="framework/lib/js/js_tools.js"></script>
        <script type="text/javascript" src="framework/lib/js/ajax/ajax.js"></script>
         

        <title><? echo $mcore->getSiteName(); ?> </title>
    </head>
    <body>

        <div id="container">

            <?php if($mcore->getSession('loged')){  ?>    
            <div class="cabecalho">
                <div class="fundo" >
                    <div class='topnav' id='topnav'>
                        <div>
                            
                            <div style='width:50px; float:right; cursor:pointer;'>
                                <a   style='color:black;'onclick="requestPage('ajax.php?class=LoginFormControl::logout()','conteudo','GET','');">
                                    <img title="Sair" src="framework/images/logout.png"/> 
                                </a> 
                            </div>
                            <div style='width:50px; margin-left:200px; float:left; cursor:pointer;'>
                                <a href="#!ajax.php?class=UsuariosListControl::show()">Usuarios</a>                                
                            </div>
                             <div style='width:50px; margin-left:200px; float:left; cursor:pointer;'>
                                <a href="#!ajax.php?class=TiposUsuariosListControl::show()">TiposUsuariosList</a>                                
                            </div>
                            
                            <div style='width:50px; margin-left:200px; float:left; cursor:pointer;'>
                                <a href="#!ajax.php?class=TiposUsuariosFormControl::show()">TiposUsuariosForm</a>                                
                            </div>
                            <?php
                                
                                // Menu no topo
                            //echo $_SESSION['monitoramento']['menu'];
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php }  ?>    
            <!--<div style="height: 1px; border-top:1px solid white;"></div>-->


            <div id="sub-conteiner">

                <div id="conteudo" class="conteudo" >
                     <?php 
                        
                        if(!$mcore->getSession('loged'))
                        {
                            $login = new LoginFormControl(); $login->show(); 
                        }                        
                     ?>    
                </div>
            </div>

        </div>


    </body>
</html>
