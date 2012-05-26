<?php


class MText extends MInput
{
    
    public function __construct($value=null, $disabled=false,$name=null, $id=null,$maxlength=null)
    {
        parent::__construct();
        $this->maxlength = $maxlength;
        $this->value = $value;
        $this->name = $name;
        $this->id = $id;
        $this->mask = null;
        $this->disabled = $disabled;
        
    }


    public function show()
    {
        parent::show();
        
        if (count($this->properties) > 0)
        {
            
            foreach ($this->properties as $key => $value)
            {
                $add .= " $key='$value' ";
            }
        }

        if ($this->mask)
        {
            $mask .= " <script> $('#{$this->id}').mask('{$this->mask}'); </script> ";
        }
        if($this->maxlength)
        {
            $maxlength= "maxlength='{$this->maxlength}'";
        }
        
        if($this->disabled)
        {
            $disabled = "readonly = 'readonly'";
        }        
        
        if($this->getObligatory())
        {
            $required = "class=\"validate['required']\"";            
        }
        return "<input name='{$this->name}' $disabled id = '{$this->id}' $add  size='{$this->size}' value='{$this->value}' {$maxlength} type='text' $required  /> $mask";
       
    }



    public function setMaxLength($maxlength)
    {
        $this->maxlength = $maxlength;
    }


    /** 
    * Add mask to input text    
    * @param String $mask
      * a - Represents an alpha character (A-Z,a-z)
      * 9 - Represents a numeric character (0-9)
      * * - Represents an alphanumeric character (A-Z,a-z,0-9)
    * @return void 
    */ 
    public function setMask($mask)
    {
        $this->mask = $mask;
    }

}

?>
