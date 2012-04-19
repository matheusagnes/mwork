<?php

class UsuariosFormControl
{

	public static function save()
	{
        for($i=0;$i<10000000;$i++){$a++;}
		
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
