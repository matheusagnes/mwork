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
