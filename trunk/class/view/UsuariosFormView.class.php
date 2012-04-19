<?php

class UsuariosFormView
{
    
    public static function show()
    {
		
		DB::exec('asd');

		//    public function __construct($name,$legend,$is_horizontal = true, $botoes = true)
        $form = new MForm('usuarios','Cadastro de Usuários',false);
        
        $form->addField('nome', 'Nome', new MText(), true);
        $form->addField('email', 'E-mail', new MText(), true);
        $form->addField('senha', 'Senha  ', new MText(), true);
        $form->addField('teste', 'Testeeeeee  ', new MCombo(), true);

        $form->show();
    }
    
}
?>
