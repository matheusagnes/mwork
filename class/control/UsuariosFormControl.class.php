<?php

class UsuariosFormControl
{

	public static function save()
	{
		
		$control = new MControl();
		
		if($control->save())
		{
			echo 'salvo';
		}
		else
		{
			echo $control->getError();
		}

	
	}


}

?>
