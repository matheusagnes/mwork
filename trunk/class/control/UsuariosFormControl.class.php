<?php

class UsuariosFormControl extends MControl
{

    public function save()
    {
        if (parent::validatePost())
        {
            $objs = parent::getPost();
            if (DB::rec($objs, 'usuarios'))
            {
                echo 'salvo com sucesso!';
            }
        }
        else
        {
            
        }
    }

}

?>
