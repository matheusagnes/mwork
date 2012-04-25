<?php

class Message
{

    // FIXME estas constantes tambem estao definidas no ajax.js
    const SUCCESS = '::SUCCESS::';
    const ERROR = '::ERROR::';
    const WARNING = '::WARNING::';

    // mensagem que aparece no form
    const HIGHLIGHT = '::HIGHLIGHT::';
    // jqueryui dialog
    const DIALOG = '::DIALOG::';

    private $type;
    private $state;
    private $message; 

    public function __construct($message, $state = self::SUCCESS, $type = self::HIGHLIGHT, $width = null, $heigth)
    {
        $this->type = $type;
        $this->state = $state;
        $this->message = $message;
        $this->show(); 
    }

    private function show()
    {
        echo $this->type . $this->state . $this->message;
    }

}
?>

