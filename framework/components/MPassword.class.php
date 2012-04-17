<?php

class MPassword extends MInput
{
    
    public function __construct($value=null, $name=null, $id=null,$maxlength=null)
    {
        parent::__construct();
        $this->maxlength = $maxlength;
        $this->value = $value;
        $this->name = $name;
        $this->id = $id;                
    }

  

    public function setMaxLength($maxlength)
    {
        $this->maxlength = $maxlength;
    }
 

    public function show()
    {
        parent::show();
       
        if (count($this->properties) > 0)
        {
            foreach ($this->properties as $key => $value)
            {
                if (strtolower(trim($key)) == 'style')
                {
                    $style = $value;
                }
                else
                {
                    $add .= " $key='$value' ";
                }
            }
        }

        if($this->maxlength)
        {
            $maxlength= "maxlength='{$this->maxlength}'";
        }
        
        if($this->getObligatory())
        {
            $required = "class=\"validate['required']\"";            
        }
        return "<input name='{$this->name}' id = '{$this->id}' $add  size='{$this->size}' value='{$this->value}' {$maxlength} type='password' $required />";
       
    }

    



}

?>
