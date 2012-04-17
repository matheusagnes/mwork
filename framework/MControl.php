<?php

class MControl
{
	#FIXME como pegar a view ? de uma forma facil para checar automaticamente os campos
    public function __construct($view)
    {
		echo $view;
    }

	public function getPost()
	{
		return $this->arrayToObject($_POST);
	}

	function arrayToObject($array) 
	{
		if(!is_array($array)) 
		{
		    return $array;
		}
    
    $object = new stdClass();
    if (is_array($array) && count($array) > 0) 
	{
      foreach ($array as $name=>$value) 
	   {
         $name = strtolower(trim($name));
         if (!empty($name)) {
            $object->$name = $this->arrayToObject($value);
         }
      }
      return $object; 
    }
    else {
      return FALSE;
    }
}

}
