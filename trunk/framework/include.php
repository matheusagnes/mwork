<?php
function __autoload($classe)
{
    if (class_exists($classe))
    {
        return true;
    }
    // Inclui componentes
    if(substr($classe, 0,1) == 'M')
    {
        $arquivo = dirname(__FILE__) . '/components/'.$classe.'.class.php';
        
        if (file_exists($arquivo))
        {
            require_once $arquivo;
            return true;
        }
        else
        {
            $arquivo =  dirname(__FILE__).'/'.$classe.'.php';

            if (file_exists($arquivo))
            {
                require_once $arquivo;
                return true;
            }
        }
    }
    else
    {
        
        if(count(explode('formView', $classe)) >= 1)
        {
            
            $arquivo = 'class/view/'.$classe.'.class.php';

            if (file_exists($arquivo))
            {
                require_once $arquivo;
                return true;
            }
        }
    }

}

?>
