<?php

class ClientesFormView
{
    
    public static function show()
    {
		// public function __construct($id, $legend, $is_horizontal = true, $urlTarget = null, $divTarget = 'conteudo')
        $form = new MForm('usuarios','Cadastro de Clientes',false);
        
        $form->addField('nome', 'Nome', new MText(), true);
        $form->addField('email', 'E-mail', new MText(), true);
        $form->addField('senha', 'Senha  ', new MText(), true);
        $form->addField('teste', 'Testeeeeee  ', new MCombo(), true);

        $form->show();
    }

	public static function show1()
    {
		// public function __construct($id, $legend, $is_horizontal = true, $urlTarget = null, $divTarget = 'conteudo')
        $form = new MForm('clientes','Cadastro de Clientes',false, 'ClientesFormControl::save1()&asdasdas');
        
        $form->addField('nome', 'Nome', new MText(), true);
        $form->addField('email', 'E-mail', new MText(), true);
        $form->addField('senha', 'Senha  ', new MText(), true);
        $form->addField('teste', 'Testeeeeee  ', new MCombo(), true);

        $form->show();
    }
    
}
?>
