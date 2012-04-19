<?php

class UsuariosFormControl
{

    public function save()
	{
		$a = new MControl();

		if(!$a->save())
		{
			echo $a->getError();		
		}		
		else
		{
			echo 'ok';		
		}
	}

}

?>
