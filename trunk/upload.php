<?php

include_once 'framework/MCore.php';
$mcore = new MCore();
$mcore = $mcore->getInstance();
$mcore->setConfigs(dirname( __FILE__ ).'/configs.php');

if(!$mcore->isLoged()) #FIXME trocar para permissao apenas temporario ou so para ver se esta logado ??
{
    new Message('Você precisa estar logado!!', Message::ERROR, Message::DIALOG);
    echo '<script> window.location.href = "index.php" </script>';
    return false;
}

$field_name = key($_FILES);
if(!preg_match('.image.',$_FILES[$field_name]['type']))
{
    echo "<script> openDialog('Arquivo não permitido!! Envie outro!', 'ERROR'); $('#{$field_name}_file').val(''); </script>";
    
    return false;
}
move_uploaded_file($_FILES[$field_name]['tmp_name'],'tmp/'.$_FILES[$field_name]['name']);

$obj->location = 'tmp/'.$_FILES[$field_name]['name'];
$obj->name = $_FILES[$field_name]['name'];
$obj->type = pathinfo($obj->location, PATHINFO_EXTENSION); 
if($_GET['edit'] == 1)
{
    $obj->edit = true;
}
$json_objFile = json_encode($obj);
echo "<script> $('#{$field_name}_file').val('{$json_objFile}'); </script>"
?>
