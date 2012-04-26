<?php

class Message
{

    const INFO = 'INFO';
    const SUCCESS = 'SUCCESS';
    const ERROR = 'ERROR';
    const WARNING = 'WARNING';

    // mensagem que aparece no form
    const HIGHLIGHT = 'HIGHLIGHT';
    // jqueryui dialog
    const DIALOG = 'DIALOG';

    private $type;
    private $state;
    private $message; 

    public function __construct($message, $state = null, $type = self::HIGHLIGHT, $width = null, $height = null)
    {
        $type = (!$type) ? self::HIGHLIGHT : $type ;

        $this->type = $type;
        $this->state = $state;
        $this->message = $message;
        $this->show(); 
    }

    private function show()
    {
        echo '<script>';
        if ($this->type == self::HIGHLIGHT)
        {
            echo 'showHighiLight("'.addslashes($this->message).'", "'.$this->state.'");';
        }
        elseif($this->type == self::DIALOG)
        {
            echo 'openDialog("'.addslashes($this->message).'","'. $this->state.'");';

        }
        echo '</script>';
    }

}
?>

