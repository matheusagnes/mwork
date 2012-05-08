<?php

class LoginFormView extends MForm
{

    public function __construct()
    {
        parent::__construct('usuarios', 'Login', false);

        parent::addField('email', 'E-mail', new MText(), true);
        parent::addField('senha', 'Senha', new MPassword(), true);
    }

}

?>
