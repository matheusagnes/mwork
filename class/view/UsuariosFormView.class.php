<?php

class UsuariosFormView
{
    
    public static function show()
    {
        $form = new MForm('usuarios','Cadastro de Usuários','',true);
        
        $form->addField('nome', 'Nome', new MText(), true);
        $form->addField('email', 'E-mail', new MText(), true);
        $form->addField('senha', 'Senha  ', new MText(), true);
        $form->addField('teste', 'Testeeeeee  ', new MCombo(), true);

        $form->show();
    }
    
}
?>
