<?php

function __autoload($classe)
{
    
    if (class_exists($classe))
    {
        return true;
    }
    // Inclui componentes
    if (substr($classe, 0, 1) == 'M')
    {
        $arquivo = dirname(__FILE__) . '/components/' . $classe . '.class.php';

        if (file_exists($arquivo))
        {
            require_once $arquivo;
            return true;
        }
        else
        {
            $arquivo = dirname(__FILE__) . '/' . $classe . '.php';
            
            if (file_exists($arquivo))
            {
                require_once $arquivo;
                return true;
            }
        }
    }
    else
    {
        
        //if (count(explode('FormView', $classe)) >= 1)
        if (preg_match('.FormView.', $classe))
        {
            $arquivo = 'class/view/' . $classe . '.class.php';

            if (file_exists($arquivo))
            {
                require_once $arquivo;
                return true;
            }
        }
        
        if (preg_match('.FormControl.', $classe) || preg_match('.Control.', $classe) )
        {
            $arquivo = 'class/control/' . $classe . '.class.php';

            if (file_exists($arquivo))
            {
                require_once $arquivo;
                return true;
            }
        }        
        if (file_exists('class/model/' . $classe . '.class.php'))
        {
            require_once 'class/model/' . $classe . '.class.php';
            return true;
        }
        
        if (preg_match('.View.', $classe) && !preg_match('.Form.', $classe))
        {            
            $arquivo = 'class/view/' . $classe . '.class.php';
            if (file_exists($arquivo))
            {
                require_once $arquivo;
                return true;
            }
        }
        
    }
}

?>
