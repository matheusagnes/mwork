<?php

class MInput
{
    protected      $name;
    protected      $obligatory;
    protected      $value;
    static         $autoname;
    protected      $properties;
    protected      $id;
    protected      $label;    
    protected      $parentForm;    
    protected      $disabled;
    
 
    function __construct()
    {
        
    }
         
    function addProperty($name,$value)
    {
        $this->properties[$name] = $value;
    }
    
    function getProperty()
    {
        return $this->properties;
    }

    function removeProperty($name)
    {
        unset($this->properties[$name]);
    }

 
    function setId($id)
    {
        $this->id = $id;
    }

    
    function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }
       
    function getDisabled()
    {
        return $this->disabled;
    }
    

    function setObligatory($obligatory)
    {
        $this->obligatory = $obligatory;
    }
    
   

    function getObligatory()
    {
        return $this->obligatory;
    }

  
    function setName($name)
    {
        $this->name = $name;
    }

   
    function getName()
    {
        return $this->name;
    }
    
    
    function getId()
    {
        return $this->id;
    }  
    
  
    public function setValue($value)
    {
        $this->value = $value;
    }

  
    function getValue()
    {
        return $this->value;
    }

  
    function getLabel()
    {
        return $this->label;
    }

  
    function setLabel($label)
    {
        $this->label = $label;      
    }    

    public final function setParentForm( $form )
    {
        $this->parentForm = $form;
    }
    
   
    public final function getParentForm()
    {
        return $this->parentForm;
    }
   

  
    function getSubmit( $formName )
    {
        return null;
    }

    function show()
    {                  
        //incluir java script e css para os ttext, mas uma vez so
    }
}
?>
