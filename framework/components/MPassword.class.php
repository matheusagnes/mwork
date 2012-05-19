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
       
        if($this->properties)
        foreach ($this->properties as $key => $value)
        {
            $add .= " $key='$value' ";
        }    

        if($this->maxlength)
        {
            $maxlength= "maxlength='{$this->maxlength}'";
        }
        
        if($this->getObligatory())
        {
            $required = "class=\"validate['required']\"";            
        }
        return "<input name='{$this->name}' id = '{$this->id}' $add  value='{$this->value}' {$maxlength} type='password' $required />";
       
    }

    



}

?>
