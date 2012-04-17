<?php

include_once 'framework/MCore.php';
$mcore = new MCore();


if ($_GET['class'])
{   
    $url = explode('::', $_GET['class']);
    $class = $url[0];
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
