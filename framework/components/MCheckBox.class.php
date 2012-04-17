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

        if ($this->aChecks && is_array($this->aChecks))
        {   
            
            $cont = 0;
            $htmlCombo = '<table class = "acessorios">';
            foreach ($this->aChecks as $key => $check)
            {
                
                $values = explode(';', $check);
                
                $check   = $values[0];
                
                if($values[1])
                {
                    $checked = "checked='1'" ;
                }
                if ($cont == 0 || $cont == 3)
                {
                    $cont = 0;
                    $htmlCombo.="<tr>";
                }
                $htmlCombo.= "<td><input $checked type='checkbox' value='{$key}' name='acessorios[]' id='{$key}_id'> <label style='cursor:pointer;'for='{$key}_id'> {$check} </label> </td> ";
                if ($cont == 3)
                {
                    $htmlCombo.="</tr>";
                    $cont = 0;
                }
                $cont++;
                unset ($checked);
            }
            $htmlCombo .= '</table>' ;
            return $htmlCombo;
        }

        unset($checked);
        if ($this->checked)
        {
            $checked = " checked = '1' ";
        }

        $htmlCheckBox = "<input id='{$this->name}' name='{$this->name}' size='{$this->size}' value='1' type='checkbox'  $checked $props >\n";
        $htmlCheckBox .= "<label for='{$this->name}'> {$this->labelCheck} </label>";
        return $htmlCheckBox;
    }

}

?>
