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
    private $title; 
    private $url; 
    private $width; 
    private $height; 

    public function __construct($message, $state = null, $type = self::HIGHLIGHT, $title = null, $width = 300, $height = 200, $url = null)
    {
        $type = (!$type) ? self::HIGHLIGHT : $type ;

        $this->type = $type;
        $this->state = $state;
        $this->message = $message;
        $this->title = $title;
        $this->url = $url;        
        $this->width = $width;
        $this->height = $height;
        $this->show(); 
    }

    private function show()
    {
        #openDialog(message, state, title, url, width, height)
        echo '<script>';
        if ($this->type == self::HIGHLIGHT)
        {
            echo 'showHighLight("'.addslashes($this->message).'", "'.$this->state.'");';
        }
        elseif($this->type == self::DIALOG)
        {
            echo 'openDialog("'.addslashes($this->message).'","'. $this->state.'","'. $this->title.'","'. $this->url.'","'. $this->width.'","'. $this->height.'");';

        }
        echo '</script>';
    }

}
?>

