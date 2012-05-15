<?php

@ini_set('display_errors', 'on');
@ini_set('html_errors', 'on');
@error_reporting(E_ALL ^ E_NOTICE);
//@ini_set('error_reporting', E_ALL);

return array(
  
    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'default_project',
    'DB_USER' => 'user',
    'DB_PASS' => 'user',
    'project_name' => 'default_project',
    'site_name' => 'Default Project'
    
);

?>
