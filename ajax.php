<?php

include_once 'framework/MCore.php';
$mcore = new MCore();
$mcore = $mcore->getInstance();  

if ($_GET['class'])
{   
    $url = explode('::', $_GET['class']);
    $class = $url[0];
    
    if(preg_match('.Control.', $class))
    {
        if(!$mcore->isLoged()) #FIXME trocar para permissao apenas temporario ou so para ver se esta logado ??
        {
            if(!preg_match('.Login.', $class))
            {
                new Message('Você precisa estar logado!!', Message::ERROR, Message::DIALOG);
                echo '<script> window.location.href = "index.php" </script>';
                return false;
            }
        }
    }
    else
    {
        new Message('Erro muito grave!!', Message::ERROR, Message::DIALOG);
        return false;
    }

    $metodo = $url[1];

    $classMetodo = $_GET['class'];

    $classe = new $class();
    //$classe::$metodo();

    if (strpos($metodo, '(') !== false)
    {
        $p = preg_split('((\))|(\())', $metodo);
        $metodo = $p[0];
        $parametros = explode(',', $p[1]);
        if ($parametros)
        {
            call_user_func_array(array($classe, $metodo), $parametros);
        }
        else
        {
            $classe->$metodo();
        }
    }
}
?>
