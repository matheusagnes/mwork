<?php

include_once '../MCore.php';
@ini_set('display_errors', 'on');
@ini_set('html_errors', 'on');
@ini_set('memory_limit', '256M');
@error_reporting(E_ALL ^ E_NOTICE);

$mcore = new MCore();
$mcore = $mcore->getInstance();
$mcore->setConfigs('/var/www/deliverys/admin/configs.php');
$mcore->setFrameworkDir('../framework');
$mcore->setProjectName('deliverys_no_vale_site');

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" http://www.w3.org/TR/html4/stric.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


        <link href="../lib/css/jquery-ui.css" rel="stylesheet" type="text/css" />
        <link href="../lib/css/framework.css" rel="stylesheet" type="text/css" />
        <link href="../lib/css/ajax.css" rel="stylesheet" type="text/css" />
        
        <script type="text/javascript" src="../lib/js/jquery.js"></script>
        <script type="text/javascript" src="../lib/js/jquery-ui.js"></script>
        
        <script type="text/javascript" src="../lib/js/ajax/jquery.ba-bbq.js"></script>
        <script type="text/javascript" src="../lib/js/open_dialog_ui.js"></script>
        <script type="text/javascript" src="../lib/js/js_tools.js"></script>
        <script type="text/javascript" src="../lib/js/ajax/ajax.js"></script>
         

        <title><? echo $mcore->getSiteName(); ?> </title>
    </head>
    <body>

        <div id="container">

              
            <div class="cabecalho">
                <div class="fundo" >
                    <div class='topnav' id='topnav'>
                        <div>
                            
                            <div style='width:50px; float:right; cursor:pointer;'>
                                <a   style='color:black;'onclick="requestPage('ajax.php?class=LoginFormControl::logout()','conteudo','GET','');">
                                    <img title="Sair" src="../images/logout.png"/> 
                                </a> 
                            </div>
                            <div style='width:50px; margin-left:200px; float:left; cursor:pointer;'>
                                <a href="#!ajax.php?class=CrudFormControl::show()">Gerador</a>                                
                            </div>
                            
                            <?php
                                
                                // Menu no topo
                            //echo $_SESSION['monitoramento']['menu'];
                            ?>
                        </div>
                    </div>
                </div>
            </div>
           
            <!--<div style="height: 1px; border-top:1px solid white;"></div>-->


            <div id="sub-conteiner">

                <div id="conteudo" class="conteudo" >
                        
                </div>
            </div>

        </div>


    </body>
</html>
