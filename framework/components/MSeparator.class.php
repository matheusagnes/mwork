<?php

class MSeparator extends MInput
{



    function __construct()
    {
        
    }


    function show()
    {
        
        return $htmlSeparator = "<tr> <td colspan = '3'> <p> {$this->name} </p> <div class= 'separadorV'> </div> </td></tr>";
    }

}

?>
