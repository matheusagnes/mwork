<?php

@ini_set('display_errors', 'on');
@error_reporting(E_ALL ^ E_NOTICE);
//@ini_set('error_reporting', E_ALL);
$mgProjectName = 'default_project';
$mgSiteName = 'Default Project';

#FIXME como passar essas variaives para a classe DB
$mgDB_DSN = 'mysql:host=localhost;dbname=default_project;';
$mgDB_USER = 'user';
$mgDB_PASS = 'user';

?>
