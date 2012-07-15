<?php
class MView
{
    public function _construct()
    {
        
    }
    
    public function getPostObject()
    {
        return arrayToObject($_POST);
    }
}
?>
