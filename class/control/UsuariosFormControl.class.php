<?php

class UsuariosFormControl
{

	public static function save()
	{
		
		$control = new MControl();
		
		// Caso queira utilizar a save padrão
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
