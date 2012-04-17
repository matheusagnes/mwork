<?php

class UsuariosFormControl
{

	public static function save()
	{
		#FIXME como pegar a view ? de uma forma facil para checar automaticamente os campos
		$control = new MControl(2);
		$objPost = $control->getPost();
		var_dump($control, $objPost->nome);
	}


}

?>
