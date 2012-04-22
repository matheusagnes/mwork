<?php

class UsuariosFormView
{
    public static function show()
    {
        //public function __construct($id, $legend, $controlName, $is_horizontal = true, $urlTarget = null, $divTarget = 'conteudo')
        $form = new MForm('usuarios', 'Cadastro de Usuários', 'UsuariosFormControl', false);

        $form->addField('nome', 'Nome', new MText(), true);
        $form->addField('email', 'E-mail', new MText(), true);
        $form->addField('senha', 'Senha  ', new MText(), true);


        $form->show();
    }

}
?>
