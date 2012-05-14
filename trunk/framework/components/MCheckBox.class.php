<?php

class MCheckBox extends MInput
{

    private $labelCheck;
    private $checked;
    private $aChecks;

  
    function __construct()
    {
        
    }

    
    function setLabelCheck($label)
    {
        $this->labelCheck = $label;
    }

    function setChecked($checked)
    {
        $this->checked = $checked;
    }

    function addChecks($aChecks)
    {
        $this->aChecks = $aChecks;
    }

 
    function show()
    {
        parent::show();

        if (count($this->properties) > 0)
        {
            $props = '';
            foreach ($this->properties as $key => $value)
            {
                $props .= ' ' . $key . '=\'' . $value . '\'';
            }
        }

       

        unset($checked);
        if ($this->checked)
        {
            $checked = " checked = '1' ";
        }
        if(!$this->value)
        {
            $this->value = 1;
        }
        $htmlCheckBox = "<input id='{$this->name}' name='{$this->name}' value='{$this->value}' type='checkbox'  $checked $props >\n";
        //$htmlCheckBox .= "<label for='{$this->name}'> {$this->labelCheck} </label>";
        return $htmlCheckBox;
    }

}

?>
