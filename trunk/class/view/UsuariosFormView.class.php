<?php

class UsuariosFormView extends MForm
{
	public function __construct()
    {
		parent::__construct('usuarios', 'Cadastro de Usuários', 'UsuariosFormControl', false);
		
		parent::addField('nome', 'Nome', new MText(), true);
        parent::addField('email', 'E-mail', new MText(), true);
        parent::addField('senha', 'Senha  ', new MText(), true);
	}
}
?>
