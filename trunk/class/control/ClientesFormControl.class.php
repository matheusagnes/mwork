<?php

class ClientesFormControl extends MControl
{

	
	public function save1()
	{
		
		if(parent::validatePost())
		{
			// Grava no banco
		}
		else
		{
			echo'Preecha todos os campos obrigatórios!';
			return false;
		}
	
	}
}


?>
