<?php

class MHtml
{
    private $html;
    
    public function __construct($html)
    {
        $this->html = $html;
    }
            
    public function setHtml($html)
    {
        $this->html = $html;
    }
    
    public function show()
    {
        return $this->html;
    }
}
?>
