<?php

class UsuariosFormControl extends MControl
{

    public function save()
    {
        if (parent::validatePost())
        {
            $post = parent::getPost();
            $post->senha = md5($post->senha);
            if (DB::rec($post, $this->getFormId()))
            {
                new Message('Dados gravados com sucesso!');
                return;
            }
            else
            {
                new Message('erro ao inserir os dados', Message::ERROR);
                return;
            }
        }
    }

}

?>
